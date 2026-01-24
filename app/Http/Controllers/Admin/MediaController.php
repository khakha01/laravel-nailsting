<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $folderId = $request->query('folder_id');
        
        $folders = \App\Models\Folder::where('parent_id', $folderId)->orderBy('name')->get();
        
        $media = Media::where('folder_id', $folderId)->latest()->get()->map(function($item) {
            $item->url = Storage::disk('minio')->url($item->file_path);
            return $item;
        });

        // Get breadcrumbs
        $breadcrumbs = [];
        $currentFolder = null;
        if ($folderId) {
            $currentFolder = \App\Models\Folder::find($folderId);
            $parent = $currentFolder;
            while ($parent) {
                array_unshift($breadcrumbs, $parent);
                $parent = $parent->parent;
            }
        }

        return response()->json([
            'folders' => $folders,
            'media' => $media,
            'breadcrumbs' => $breadcrumbs,
            'current_folder' => $currentFolder
        ]);
    }

    public function storeFolder(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id'
        ]);

        $folder = \App\Models\Folder::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return response()->json([
            'success' => true,
            'folder' => $folder
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB
            'folder_id' => 'nullable|exists:folders,id'
        ]);

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        // Generate unique filename
        $fileName = Str::uuid() . '.' . $extension;

        // Build path based on folder structure
        $folderPath = 'media'; // Default root path
        if ($request->folder_id) {
            $folder = Folder::find($request->folder_id);
            if ($folder) {
                $folderPath = $folder->getFullPath();
            }
        }

        try {
            // Upload to MinIO with folder structure
            $path = "{$folderPath}/{$fileName}";
            Storage::disk('minio')->put($path, file_get_contents($file->getRealPath()));
            
            // Generate full URL
            $url = Storage::disk('minio')->url($path);

        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            if ($e->getPrevious()) {
                $errorMsg .= " | Previous: " . $e->getPrevious()->getMessage();
            }
            \Illuminate\Support\Facades\Log::error('MinIO Upload Error: ' . $errorMsg);
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $errorMsg
            ], 500);
        }

        // Save to DB
        $media = Media::create([
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'folder_id' => $request->folder_id
        ]);

        return response()->json([
            'success' => true,
            'media' => $media,
            'url' => Storage::disk('minio')->url($path)
        ]);
    }

    public function destroy($id)
    {
        $media = Media::withCount('nails')->findOrFail($id);

        if ($media->nails_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete media in use by nails'
            ], 400);
        }

        // Delete from Storage
        Storage::disk('minio')->delete($media->file_path);

        // Delete from DB
        $media->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Bulk delete multiple media files
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id'
        ]);

        $ids = $request->ids;
        $deleted = [];
        $failed = [];

        foreach ($ids as $id) {
            $media = Media::withCount('nails')->find($id);
            
            if (!$media) {
                $failed[] = ['id' => $id, 'reason' => 'Not found'];
                continue;
            }

            if ($media->nails_count > 0) {
                $failed[] = ['id' => $id, 'reason' => 'In use by nails'];
                continue;
            }

            try {
                // Delete from Storage
                Storage::disk('minio')->delete($media->file_path);
                // Delete from DB
                $media->delete();
                $deleted[] = $id;
            } catch (\Exception $e) {
                $failed[] = ['id' => $id, 'reason' => $e->getMessage()];
            }
        }

        return response()->json([
            'success' => true,
            'deleted' => $deleted,
            'failed' => $failed,
            'message' => count($deleted) . ' media deleted, ' . count($failed) . ' failed'
        ]);
    }

    public function destroyFolder($id)
    {
        $folder = Folder::findOrFail($id);
        
        // Get all media in this folder and subfolders
        $allMedia = $folder->getAllMedia();
        
        // Delete all media files from MinIO
        foreach ($allMedia as $media) {
            try {
                Storage::disk('minio')->delete($media->file_path);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to delete media file: {$media->file_path} - " . $e->getMessage());
            }
        }
        
        // Delete all media records from database
        Media::whereIn('id', $allMedia->pluck('id'))->delete();
        
        // Get all subfolders (including this folder)
        $allFolders = $folder->getAllSubfolders();
        
        // Delete all folders from database (cascade from bottom to top)
        Folder::whereIn('id', $allFolders->pluck('id'))->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Folder and all contents deleted successfully'
        ]);
    }
}

