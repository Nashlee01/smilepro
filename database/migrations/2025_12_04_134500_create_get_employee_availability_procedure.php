<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGetEmployeeAvailabilityProcedure extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'sqlite') {
            $procedure = "
            CREATE PROCEDURE GetEmployeeAvailability(IN employeeId INT, IN checkDate DATE)
            BEGIN
                SELECT 
                    u.name as employee_name,
                    u.role as employee_role,
                    ea.date,
                    ea.start_time,
                    ea.end_time
                FROM 
                    users u
                LEFT JOIN 
                    employee_availabilities ea ON u.id = ea.user_id 
                    AND ea.date = checkDate
                WHERE 
                    u.id = employeeId
                    AND u.status = 'active';
            END";

            DB::unprepared("DROP PROCEDURE IF EXISTS GetEmployeeAvailability");
            DB::unprepared($procedure);
        }
    }

    public function down()
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::unprepared("DROP PROCEDURE IF EXISTS GetEmployeeAvailability");
        }
    }
}
