<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();
        });

        $create = $this->createMaster();
        $processStatus = \App\PaidStatus::where('slug', 'process')->first();

        Schema::table('products', function (Blueprint $table) use($processStatus){
            if (!Schema::hasColumn('products', 'paid_status_id')) {
                $table->unsignedBigInteger('paid_status_id')
                    ->after('order_no')
                    ->default($processStatus->id);
            }
        });
        Schema::table('balances', function (Blueprint $table) use($processStatus){
            if (!Schema::hasColumn('balances', 'paid_status_id')) {
                $table->unsignedBigInteger('paid_status_id')
                    ->after('order_no')
                    ->default($processStatus->id);
            }
        });
    }

    private function createMaster(){
        $statuses = ['process','fail','success','cancel'];
        $statusNames = ['Process', 'Failed', 'Success', 'Canceled'];

        \Illuminate\Support\Facades\DB::beginTransaction();
        foreach ($statuses as $idx => $status){
            \App\PaidStatus::create([
                'slug' => $status,
                'name' => $statusNames[$idx]
            ]);
        }
        \Illuminate\Support\Facades\DB::commit();

        return true;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paid_statuses');
    }
}
