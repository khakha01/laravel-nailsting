<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;

class SeedPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed permissions từ config vào database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Bắt đầu seed permissions từ config...');

        $permissions = config('permissions');
        $createdCount = 0;
        $skippedCount = 0;

        foreach ($permissions as $group => $items) {
            $this->info("Processing group: {$group}");

            foreach ($items as $code => $name) {
                // Kiểm tra xem permission đã tồn tại hay chưa
                $existingPermission = Permission::where('code', $code)->first();

                if ($existingPermission) {
                    $this->line("  ⊘ {$code} - Đã tồn tại");
                    $skippedCount++;
                } else {
                    Permission::create([
                        'group' => $group,
                        'code' => $code,
                        'name' => $name,
                        'description' => null,
                    ]);

                    $this->line("  ✓ {$code} - Tạo thành công");
                    $createdCount++;
                }
            }
        }

        $this->newLine();
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("Tổng quyền tạo mới: {$createdCount}");
        $this->info("Tổng quyền bỏ qua: {$skippedCount}");
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

        return Command::SUCCESS;
    }
}
