<?php

namespace App\Listeners;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Events\ProductDeleted;

class BackupProductChanges
{
    public function created(ProductCreated $event)
    {
        $this->backup();
    }

    public function updated(ProductUpdated $event)
    {
        $this->backup();
    }

    public function deleted(ProductDeleted $event)
    {
        $this->backup();
    }

    protected function backup()
    {
        $tableName = 'products';
        $backupFileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $backupPath = storage_path('app/backups/' . $backupFileName);

        // Get data from products table
        $data = DB::table($tableName)->get()->toArray();

        // Generate SQL statements for insert
        $sql = '';
        foreach ($data as $row) {
            $values = implode("','", array_map('addslashes', (array) $row));
            $sql .= "INSERT INTO $tableName VALUES ('$values');\n";
        }

        // Write SQL statements to backup file
        File::put($backupPath, $sql);
    }
}
