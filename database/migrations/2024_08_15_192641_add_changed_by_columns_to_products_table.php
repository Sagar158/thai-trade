<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangedByColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('changed_by_lc')->nullable()->after('existing_column');
            $table->integer('changed_by_cost')->nullable()->after('changed_by_lc');
            $table->integer('changed_by_ntf_cs')->nullable()->after('changed_by_cost');
            $table->integer('changed_by_print')->nullable()->after('changed_by_ntf_cs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['changed_by_lc', 'changed_by_cost', 'changed_by_ntf_cs', 'changed_by_print']);
        });
    }
}


?>
