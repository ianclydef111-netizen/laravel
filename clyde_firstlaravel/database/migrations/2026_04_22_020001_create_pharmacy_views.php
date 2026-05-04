<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // VIEW 1: Low stock medicines
        DB::unprepared('
            CREATE VIEW vw_low_stock_medicines AS
            SELECT
                m.id,
                m.generic_name,
                m.brand_name,
                c.name AS category,
                m.stock_level,
                m.reorder_level,
                (m.reorder_level - m.stock_level) AS shortage_amount
            FROM medicines m
            JOIN categories c ON m.category_id = c.id
            WHERE m.stock_level <= m.reorder_level
            ORDER BY shortage_amount DESC
        ');

        // VIEW 2: Expiring batches
        DB::unprepared('
            CREATE VIEW vw_expiring_batches AS
            SELECT
                b.id AS batch_id,
                b.batch_number,
                m.generic_name,
                m.brand_name,
                b.expiry_date,
                b.stock_quantity,
                DATEDIFF(b.expiry_date, CURDATE()) AS days_remaining,
                CASE
                    WHEN b.expiry_date < CURDATE() THEN &#x27;Expired&#x27;
                    WHEN DATEDIFF(b.expiry_date, CURDATE()) <= 30 THEN &#x27;Expiring Soon&#x27;
                    ELSE &#x27;OK&#x27;
                END AS expiry_status
            FROM batches b
            JOIN medicines m ON b.medicine_id = m.id
            WHERE b.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
            ORDER BY b.expiry_date ASC
        ');

        // VIEW 3: Daily sales summary
        DB::unprepared('
            CREATE VIEW vw_daily_sales_summary AS
            SELECT
                s.sale_date,
                COUNT(s.id) AS total_transactions,
                SUM(s.total_price) AS total_revenue,
                AVG(s.total_price) AS average_sale_value,
                u.name AS clerk_name
            FROM sales s
            JOIN users u ON s.user_id = u.id
            GROUP BY s.sale_date, u.name
            ORDER BY s.sale_date DESC
        ');

        // VIEW 4: Prescription status report
        DB::unprepared('
            CREATE VIEW vw_prescription_status_report AS
            SELECT
                p.id AS prescription_id,
                p.patient_name,
                p.doctor_name,
                p.prescription_date,
                p.status,
                s.id AS linked_sale_id,
                s.sale_date,
                DATEDIFF(CURDATE(), p.created_at) AS days_since_upload
            FROM prescriptions p
            LEFT JOIN sales s ON s.prescription_id = p.id
            ORDER BY p.created_at DESC
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS vw_low_stock_medicines');
        DB::unprepared('DROP VIEW IF EXISTS vw_expiring_batches');
        DB::unprepared('DROP VIEW IF EXISTS vw_daily_sales_summary');
        DB::unprepared('DROP VIEW IF EXISTS vw_prescription_status_report');
    }
};
