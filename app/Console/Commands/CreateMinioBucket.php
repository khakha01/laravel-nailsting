<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class CreateMinioBucket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minio:create-bucket {bucket?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a bucket in MinIO if it does not exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bucketName = $this->argument('bucket') ?? config('filesystems.disks.minio.bucket');

        try {
            $client = new S3Client([
                'version' => 'latest',
                'region' => config('filesystems.disks.minio.region'),
                'endpoint' => config('filesystems.disks.minio.endpoint'),
                'use_path_style_endpoint' => config('filesystems.disks.minio.use_path_style_endpoint'),
                'credentials' => [
                    'key' => config('filesystems.disks.minio.key'),
                    'secret' => config('filesystems.disks.minio.secret'),
                ],
            ]);

            // Check if bucket exists
            if ($client->doesBucketExist($bucketName)) {
                $this->info("Bucket '{$bucketName}' already exists.");
                return 0;
            }

            // Create the bucket
            $client->createBucket([
                'Bucket' => $bucketName,
            ]);

            $this->info("Bucket '{$bucketName}' created successfully!");

            // Optional: Set bucket policy to public-read
            if ($this->confirm('Do you want to make this bucket publicly readable?', true)) {
                $policy = json_encode([
                    'Version' => '2012-10-17',
                    'Statement' => [
                        [
                            'Effect' => 'Allow',
                            'Principal' => ['AWS' => ['*']],
                            'Action' => ['s3:GetObject'],
                            'Resource' => ["arn:aws:s3:::{$bucketName}/*"],
                        ],
                    ],
                ]);

                $client->putBucketPolicy([
                    'Bucket' => $bucketName,
                    'Policy' => $policy,
                ]);

                $this->info("Bucket policy set to public-read.");
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to create bucket: " . $e->getMessage());
            return 1;
        }
    }
}
