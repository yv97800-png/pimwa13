<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลการลงทะเบียน</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background: linear-gradient(135deg, #f8eaec 0%, #efd2d6 100%);
            min-height: 100vh;
            margin: 0;
            padding: 36px 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #2b1215;
        }

        .card {
            width: 100%;
            max-width: 480px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 16px 36px rgba(75, 13, 22, 0.15);
            overflow: hidden;
            border: 1px solid rgba(124, 28, 38, 0.12);
        }

        .card-header {
            background: linear-gradient(135deg, #4b0d16 0%, #7c1c26 100%);
            padding: 20px 24px;
            border-bottom: 3px solid #d49b6a;
        }

        .card-header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 21px;
            font-weight: 600;
        }

        .card-body {
            padding: 24px;
        }

        .info-list {
            background-color: #fff9fa;
            border: 1px solid #ecd0d3;
            border-radius: 12px;
            padding: 6px 16px;
            margin-bottom: 18px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px dashed #e7c6ca;
            font-size: 14.5px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6e232b;
            font-weight: 500;
            white-space: nowrap;
        }

        .info-value {
            color: #2b1215;
            font-weight: 400;
            text-align: right;
            word-break: break-word;
        }

        .alert-success {
            background-color: #fdf1f2;
            border: 1px solid #e2b4b9;
            border-left: 4px solid #7c1c26;
            color: #5a121a;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 14.5px;
            margin-bottom: 20px;
        }

        .alert-error {
            background-color: #fff1f2;
            border: 1px solid #f0b6bc;
            border-left: 4px solid #b91c1c;
            color: #7f1d1d;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 14.5px;
            margin-bottom: 20px;
            word-break: break-word;
        }

        .alert-warning {
            background-color: #fffaf0;
            border: 1px solid #f3d59b;
            border-left: 4px solid #c48341;
            color: #6b4218;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 14.5px;
            margin-bottom: 20px;
        }

        .btn-back {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px 18px;
            background: linear-gradient(135deg, #7c1c26 0%, #9b2632 100%);
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(124, 28, 38, 0.22);
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(124, 28, 38, 0.3);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h1>ผลการลงทะเบียน</h1>
        </div>
        <div class="card-body">
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname   = $_POST["fullname"];
        $student_id = $_POST["student_id"];
        $gender     = $_POST["gender"];
        $level      = $_POST["level"];
        $email      = $_POST["email"];

        try {
            $conn = new PDO("mysql:host=localhost;dbname=student_db;charset=utf8mb4", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO students (fullname, student_id, gender, level, email)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fullname, $student_id, $gender, $level, $email]);

            echo '<div class="info-list">';
            echo '<div class="info-row"><span class="info-label">ชื่อ-สกุล</span><span class="info-value">' . htmlspecialchars($fullname) . '</span></div>';
            echo '<div class="info-row"><span class="info-label">รหัสนักเรียน</span><span class="info-value">' . htmlspecialchars($student_id) . '</span></div>';
            echo '<div class="info-row"><span class="info-label">เพศ</span><span class="info-value">' . htmlspecialchars($gender) . '</span></div>';
            echo '<div class="info-row"><span class="info-label">ระดับชั้น</span><span class="info-value">' . htmlspecialchars($level) . '</span></div>';
            echo '<div class="info-row"><span class="info-label">อีเมล</span><span class="info-value">' . htmlspecialchars($email) . '</span></div>';
            echo '</div>';

            echo '<div class="alert-success"><strong>บันทึกข้อมูลลงฐานข้อมูลเรียบร้อยแล้ว</strong></div>';
        } catch (PDOException $e) {
            echo '<div class="alert-error"><strong>บันทึกไม่สำเร็จ:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        echo '<div class="alert-warning">กรุณากรอกข้อมูลจากหน้าแบบฟอร์ม</div>';
    }
?>
            <a href="form.html" class="btn-back">กลับไปหน้าแบบฟอร์ม</a>
        </div>
    </div>
</body>
</html>