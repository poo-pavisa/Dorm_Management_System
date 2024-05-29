# Dormitory Management System (ระบบบริหารจัดการหอพัก)
------------------------------------------------
#### Pavisa Sirirojvorakul | 
---------------------------------------------------
### ขั้นตอนการติดตั้ง
#####  1. git clone https://github.com/poo-pavisa/Dorm_Management_System.git
#####  2. แก้ไขไฟล์.env ให้ DB_HOST=mysql
#####  3. composer require laravel/sail --dev
#####  4. php artisan key:generate
#####  5. ./vendor/bin/sail up หรือ sail up (กรณีใช้คำสั่งนี้ต้องconfigเพิ่มเติม)
#####  6. sail artisan migrate
---------------------------------------------------
### การเข้าหน้าเว็บไซต์
##### ฝั่งผุ้ใช้งานทั่วไป : localhost
##### ฝั่งผู้ดูแลหลังบ้าน : localhost/nova
##### ฐานข้อมูล : localhost:8001
---------------------------------------------------
### วิธีการเพิ่มผู้ดูแลหลังบ้าน
##### sail artisan nova:user
