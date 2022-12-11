<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // users table
        // DB::unprepared(
        //     'CREATE TRIGGER `insert_user` AFTER INSERT ON `users` FOR EACH ROW
        //     BEGIN
        //         DECLARE `check` INT;
        //         SELECT COUNT(*) INTO `check` FROM `bus_companies` WHERE `IdNX` = NEW.`IdNX`;
        //             IF `check` = 0 THEN
        //                 SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Nhà xe không tồn tại";
        //             END IF;
        //     END;'
        // );

        // DB::unprepared(
        //     'CREATE TRIGGER `update_user` BEFORE UPDATE ON `users` FOR EACH ROW
        //     BEGIN
        //         @check = (SELECT COUNT(*) FROM bus_companies WHERE IdNX = NEW.IdNX);
        //         IF @check = 0 THEN
        //             SIGNAL SQLSTATE \'45000\'
        //             SET MESSAGE_TEXT = \'Không tồn tại nhà xe\';
        //         END IF;

        //         ROLLBACK;
        //     END;'
        // );

        // // buses table
        // DB::unprepared(
        //     'CREATE TRIGGER `insert_bus` BEFORE INSERT ON `buses` FOR EACH ROW
        //     BEGIN
        //         @check = (SELECT COUNT(*) FROM bus_companies WHERE IdNX = NEW.IdNX);
        //         IF @check = 0 THEN
        //             SIGNAL SQLSTATE \'45000\'
        //             SET MESSAGE_TEXT = \'Không tồn tại nhà xe\';
        //         END IF;

        //         ROLLBACK;
        //     END;'
        // );

        // DB::unprepared(
        //     'CREATE TRIGGER `update_bus` BEFORE UPDATE ON `buses` FOR EACH ROW
        //     BEGIN
        //         @check = (SELECT COUNT(*) FROM bus_companies WHERE IdNX = NEW.IdNX);
        //         IF @check = 0 THEN
        //             SIGNAL SQLSTATE \'45000\'
        //             SET MESSAGE_TEXT = \'Không tồn tại nhà xe\';
        //         END IF;

        //         ROLLBACK;
        //     END;'
        // );

        // // bus_routes table
        // DB::unprepared(
        //     'CREATE TRIGGER `insert_bus_route` BEFORE INSERT ON `bus_routes` FOR EACH ROW
        //     BEGIN
        //         @check= (SELECT COUNT(*) FROM bus_routes WHERE TenTuyen = NEW.TenTuyen)
        //         IF @check > 0 THEN
        //             SIGNAL SQLSTATE \'45000\'
        //             SET MESSAGE_TEXT = \'Tuyến đã tồn tại\';
        //         END IF;

        //         @DiaDiemDi = (SELECT DiaDiemDi FROM bus_routes WHERE DiaDiemDi = NEW.DiaDiemDi);
        //         @DiaDiemDen = (SELECT DiaDiemDen FROM bus_routes WHERE DiaDiemDen = NEW.DiaDiemDen);

        //         IF @DiaDiemDi = @DiaDiemDen THEN
        //             SIGNAL SQLSTATE \'45000\'
        //             SET MESSAGE_TEXT = \'Điểm đi và điểm đến không được trùng nhau\';
        //         END IF;


        //         ROLLBACK;
        //     END;'
        // );

        // DB::unprepared(
        //     'CREATE TRIGGER `update_bus_route` BEFORE UPDATE ON `bus_routes` FOR EACH ROW
        //     BEGIN
        //         @check= (SELECT COUNT(*) FROM bus_routes WHERE TenTuyen = NEW.TenTuyen)
        //         IF @check > 0 THEN
        //             SIGNAL SQLSTATE \'45000\'
        //             SET MESSAGE_TEXT = \'Tuyến đã tồn tại\';
        //         END IF;

        //         @DiaDiemDi = (SELECT DiaDiemDi FROM bus_routes WHERE DiaDiemDi = NEW.DiaDiemDi);
        //         @DiaDiemDen = (SELECT DiaDiemDen FROM bus_routes WHERE DiaDiemDen = NEW.DiaDiemDen);

        //         IF @DiaDiemDi = @DiaDiemDen THEN
        //             SIGNAL SQLSTATE \'45000\'
        //             SET MESSAGE_TEXT = \'Điểm đi và điểm đến không được trùng nhau\';
        //         END IF;

        //         ROLLBACK;
        //     END;'
        // );

        // ticket_details table
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // users table
        // DB::unprepared('DROP TRIGGER `insert_user`');
        // DB::unprepared('DROP TRIGGER `update_user`');

        // // buses table
        // DB::unprepared('DROP TRIGGER `insert_bus`');
        // DB::unprepared('DROP TRIGGER `update_bus`');

        // // bus_routes table
        // DB::unprepared('DROP TRIGGER `insert_bus_route`');
        // DB::unprepared('DROP TRIGGER `update_bus_route`');
    }
};
