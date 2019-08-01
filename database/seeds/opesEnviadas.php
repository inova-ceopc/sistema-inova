<?php

use Illuminate\Database\Seeder;

class opesEnviadas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>11,'dia' => '2019-07-03',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>15,'dia' => '2019-07-04',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>2,'dia' => '2019-07-05',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>31,'dia' => '2019-07-08',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>13,'dia' => '2019-07-10',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>43,'dia' => '2019-07-11',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>11,'dia' => '2019-07-15',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>28,'dia' => '2019-07-16',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>19,'dia' => '2019-07-17',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>16,'dia' => '2019-07-18',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>19,'dia' => '2019-07-19',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>6,'dia' => '2019-07-22',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>12,'dia' => '2019-07-23',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>15,'dia' => '2019-07-24',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>1,'dia' => '2019-07-25',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>36,'dia' => '2019-07-26',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>12,'dia' => '2019-07-29',]);
        DB::table('tbl_SIEXC_OPES_ENVIADAS')->insert(['quantidade' =>16,'dia' => '2019-07-31',]);
    }
}
