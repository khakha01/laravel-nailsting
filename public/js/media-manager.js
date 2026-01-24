class MediaManager {
    constructor(config) {
        this.config = Object.assign({
            selectors: {
                modal: 'media-modal',
                grid: 'mm-grid',
                breadcrumbs: 'mm-breadcrumbs',
                empty: 'mm-empty',
                loader: 'mm-loader',
                status: 'mm-status',
                selectedContainer: 'selected-images-container',
                hiddenInputs: 'hidden-inputs-wrapper',
                noSelectionText: 'no-selection-text'
            },
            urls: {
                index: '',
                folderStore: '',
                folderDelete: '',
                store: '',
                mediaDelete: '',
                mediaBulkDelete: ''
            },
            csrfToken: ''
        }, config);

        this.state = {
            currentFolderId: null,
            folders: [],
            media: [],
            breadcrumbs: [],
            selectedItemsMap: new Map()
        };

        this.init();
    }

    init() {
        // Bind methods to window so existing inline onclick handlers work
        window.openMediaModal = () => this.openMediaModal();
        window.closeMediaModal = () => this.closeMediaModal();
        window.loadFolder = (id) => this.loadFolder(id);
        window.createNewFolder = () => this.createNewFolder();
        window.deleteFolder = (e, id) => this.deleteFolder(e, id);
        window.uploadFile = (input) => this.uploadFile(input);
        window.confirmSelection = () => this.confirmSelection();
        window.removeSelection = (id) => this.removeSelection(id);
        window.deleteMedia = (e, id) => this.deleteMedia(e, id);
        window.deleteSelectedMedia = () => this.deleteSelectedMedia();

        // Internal helper exposed if needed for event propagation logic
        window.toggleSelection = (item) => this.toggleSelection(item);
    }

    openMediaModal() {
        console.log('Opening Media Modal');
        const modal = document.getElementById(this.config.selectors.modal);
        if (modal) {
            modal.classList.remove('hidden');
            this.loadFolder(this.state.currentFolderId);
        } else {
            console.error('Media modal element not found');
        }
    }

    closeMediaModal() {
        const modal = document.getElementById(this.config.selectors.modal);
        if (modal) modal.classList.add('hidden');
    }

    loadFolder(folderId) {
        this.state.currentFolderId = folderId;
        this.setLoader(true);

        let url = this.config.urls.index;
        if (folderId) {
            url += (url.includes('?') ? '&' : '?') + 'folder_id=' + folderId;
        }

        console.log('Fetching', url);

        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(res => res.json())
            .then(data => {
                this.state.folders = data.folders || [];
                this.state.media = data.media || [];
                this.state.breadcrumbs = data.breadcrumbs || [];
                this.renderExplorer();
                this.updateStatus();
            })
            .catch(err => {
                console.error('Error loading folder:', err);
                const grid = document.getElementById(this.config.selectors.grid);
                if (grid) grid.innerHTML = '<p class="text-red-500 p-4">Error loading content.</p>';
            })
            .finally(() => this.setLoader(false));
    }

    renderExplorer() {
        const grid = document.getElementById(this.config.selectors.grid);
        const empty = document.getElementById(this.config.selectors.empty);
        const bcContainer = document.getElementById(this.config.selectors.breadcrumbs);

        if (!grid || !empty || !bcContainer) return;

        grid.innerHTML = '';

        // Render Breadcrumbs
        let bcHtml = `<span class="cursor-pointer hover:text-indigo-600 font-bold" onclick="loadFolder(null)">Home</span>`;
        this.state.breadcrumbs.forEach(B => {
            bcHtml += ` <span class="text-gray-400">/</span> <span class="cursor-pointer hover:text-indigo-600" onclick="loadFolder(${B.id})">${B.name}</span>`;
        });
        bcContainer.innerHTML = bcHtml;

        if (this.state.folders.length === 0 && this.state.media.length === 0) {
            empty.classList.remove('hidden');
        } else {
            empty.classList.add('hidden');

            // Allow going up if not root
            if (this.state.currentFolderId) {
                const upDiv = document.createElement('div');
                upDiv.className = 'flex flex-col items-center justify-center p-4 border border-transparent rounded hover:bg-gray-100 cursor-pointer text-gray-500';
                upDiv.onclick = () => {
                    if (this.state.breadcrumbs.length >= 2) {
                        this.loadFolder(this.state.breadcrumbs[this.state.breadcrumbs.length - 2].id);
                    } else {
                        this.loadFolder(null); // Root
                    }
                };
                upDiv.innerHTML = `
                    <svg class="w-12 h-12 mb-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                    <span class="text-xs text-center truncate w-full">.. (Up)</span>
                 `;
                grid.appendChild(upDiv);
            }

            // Folders
            this.state.folders.forEach(f => {
                const el = document.createElement('div');
                el.className = 'flex flex-col items-center p-2 border border-transparent rounded hover:bg-gray-100 cursor-pointer group relative';
                // Double click or single click to open? Original had both.
                el.ondblclick = () => this.loadFolder(f.id);
                el.onclick = () => this.loadFolder(f.id);

                el.innerHTML = `
                    <svg class="w-16 h-16 text-yellow-400 mb-1" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/></svg>
                    <span class="text-xs text-center w-full truncate px-1 text-gray-700 font-medium">${f.name}</span>
                    <button onclick="deleteFolder(event, ${f.id})" class="absolute top-1 right-1 hidden group-hover:block text-gray-400 hover:text-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;
                grid.appendChild(el);
            });

            // Files
            this.state.media.forEach(m => {
                const idStr = String(m.id);
                const isSel = this.state.selectedItemsMap.has(idStr);
                const itemJson = JSON.stringify(m).replace(/"/g, '&quot;'); // Escape for attribute

                const el = document.createElement('div');
                el.className = `relative aspect-w-1 aspect-h-1 group cursor-pointer border-2 rounded-lg overflow-hidden ${isSel ? 'border-indigo-600 ring-2 ring-indigo-300' : 'border-gray-200 hover:border-gray-300'}`;

                // We need to pass the object to toggleSelection. 
                // Since we're in a loop, we can just bind the function in the onclick handler closure.
                el.onclick = (e) => {
                    e.stopPropagation();
                    this.toggleSelection(m);
                };

                el.innerHTML = `
                    <img src="${m.url}" class="object-cover w-full h-32 bg-gray-50">
                    ${isSel ? '<div class="absolute inset-0 bg-indigo-600 bg-opacity-20 flex items-center justify-center"><svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>' : ''}
                    <button onclick="deleteMedia(event, ${m.id})" class="absolute top-1 right-1 hidden group-hover:block bg-red-500 text-white p-1 rounded hover:bg-red-600 focus:outline-none z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                `;
                grid.appendChild(el);
            });
        }
    }

    toggleSelection(item) {
        const id = String(item.id);
        if (this.state.selectedItemsMap.has(id)) {
            this.state.selectedItemsMap.delete(id);
        } else {
            this.state.selectedItemsMap.set(id, item);
        }
        this.renderExplorer();
        this.updateStatus();
    }

    updateStatus() {
        const count = this.state.selectedItemsMap.size;
        const statusEl = document.getElementById(this.config.selectors.status);
        const deleteBtn = document.getElementById('mm-delete-selected-btn');

        if (statusEl) {
            statusEl.innerText = count > 0 ? `${count} item(s) selected` : 'No items selected';
        }

        // Show/hide delete button based on selection
        if (deleteBtn) {
            if (count > 0) {
                deleteBtn.classList.remove('hidden');
            } else {
                deleteBtn.classList.add('hidden');
            }
        }
    }

    setLoader(show) {
        const el = document.getElementById(this.config.selectors.loader);
        if (el) {
            if (show) el.classList.remove('hidden');
            else el.classList.add('hidden');
        }
    }

    createNewFolder() {
        const name = prompt("Enter folder name:");
        if (!name) return;

        const data = {
            name: name,
            parent_id: this.state.currentFolderId
        };

        fetch(this.config.urls.folderStore, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.config.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(res => res.json())
            .then(data => {
                if (data.folder) {
                    this.loadFolder(this.state.currentFolderId);
                }
            });
    }

    deleteFolder(e, id) {
        e.stopPropagation();
        if (!confirm('Delete this folder?')) return;

        // Ensure folderDelete URL ends with slash if needed or handle appending
        const baseUrl = this.config.urls.folderDelete.replace(/\/+$/, '');
        const url = `${baseUrl}/${id}`;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': this.config.csrfToken,
                'Accept': 'application/json'
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.loadFolder(this.state.currentFolderId);
                }
            });
    }

    deleteMedia(e, id) {
        e.stopPropagation();
        if (!confirm('Are you sure you want to delete this image? This action cannot be undone.')) return;

        const baseUrl = this.config.urls.mediaDelete.replace(/\/+$/, '');
        const url = `${baseUrl}/${id}`;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': this.config.csrfToken,
                'Accept': 'application/json'
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Remove from selected items if it was selected
                    this.state.selectedItemsMap.delete(String(id));
                    // Reload current folder
                    this.loadFolder(this.state.currentFolderId);
                } else {
                    alert(data.message || 'Failed to delete media');
                }
            })
            .catch(err => {
                console.error('Error deleting media:', err);
                alert('Error deleting media');
            });
    }

    deleteSelectedMedia() {
        const selected = this.state.selectedItemsMap;
        if (selected.size === 0) {
            alert('No media selected');
            return;
        }

        const count = selected.size;
        if (!confirm(`Are you sure you want to delete ${count} selected image(s)? This action cannot be undone.`)) {
            return;
        }

        const ids = Array.from(selected.keys());

        this.setLoader(true);

        fetch(this.config.urls.mediaBulkDelete, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.config.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Clear selection
                    this.state.selectedItemsMap.clear();
                    // Show result message
                    if (data.failed && data.failed.length > 0) {
                        alert(`Deleted: ${data.deleted.length}\nFailed: ${data.failed.length}\n\nFailed items:\n` +
                            data.failed.map(f => `ID ${f.id}: ${f.reason}`).join('\n'));
                    } else {
                        alert(`Successfully deleted ${data.deleted.length} image(s)`);
                    }
                    // Reload current folder
                    this.loadFolder(this.state.currentFolderId);
                } else {
                    alert(data.message || 'Failed to delete media');
                }
            })
            .catch(err => {
                console.error('Error deleting media:', err);
                alert('Error deleting media');
            })
            .finally(() => {
                this.setLoader(false);
            });
    }

    uploadFile(input) {
        const file = input.files[0];
        if (!file) return;

        const fd = new FormData();
        fd.append('image', file);
        if (this.state.currentFolderId) {
            fd.append('folder_id', this.state.currentFolderId);
        }

        this.setLoader(true);

        fetch(this.config.urls.store, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': this.config.csrfToken,
                'Accept': 'application/json'
            },
            body: fd
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.loadFolder(this.state.currentFolderId);
                } else {
                    alert('Upload failed: ' + (data.message || 'Unknown'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error uploading');
            })
            .finally(() => {
                input.value = '';
                this.setLoader(false);
            });
    }

    confirmSelection() {
        const container = document.getElementById(this.config.selectors.selectedContainer);
        const inputsWrapper = document.getElementById(this.config.selectors.hiddenInputs);
        const noSelectionText = document.getElementById(this.config.selectors.noSelectionText);

        if (!container || !inputsWrapper) return;

        container.innerHTML = '';
        inputsWrapper.innerHTML = '';

        if (this.state.selectedItemsMap.size === 0) {
            if (noSelectionText) container.appendChild(noSelectionText);
            this.closeMediaModal();
            return;
        }

        this.state.selectedItemsMap.forEach((item, id) => {
            const div = document.createElement('div');
            div.className = 'relative group h-24 w-24 rounded-md overflow-hidden border border-gray-200';
            div.innerHTML = `
                <img src="${item.url}" class="h-full w-full object-cover">
                <button type="button" onclick="removeSelection('${item.id}')" class="absolute top-0 right-0 bg-red-500 text-white p-0.5 rounded-bl hover:bg-red-600 focus:outline-none">
                     <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;
            container.appendChild(div);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'media_ids[]';
            input.value = item.id;
            inputsWrapper.appendChild(input);
        });

        this.closeMediaModal();
    }

    removeSelection(id) {
        id = String(id);
        this.state.selectedItemsMap.delete(id);
        this.confirmSelection();
    }
}
