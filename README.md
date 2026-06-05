# 🩸 BloodConnect Bangladesh

A production-ready Laravel 11 + PHP 8.3 + FilamentPHP v3 web application for managing blood donations and emergency blood requests in Bangladesh.

## 🌟 Features

### User Roles
- **Super Admin** - Full system control
- **Moderator** - Approval workflow management
- **Donor** - Blood donation management
- **Receiver** - Temporary account (24 hours) for blood requests

### Core Modules

#### 👥 User Registration System
- Donor registration with complete personal/medical information
- Auto-generated Donor IDs
- Email & WhatsApp verification
- Account eligibility tracking
- Donation history management

#### 🆘 Emergency Blood Request System
- Real-time blood request creation
- Automatic donor notification (Email, WhatsApp, Push)
- Request status tracking (Pending → Accepted → Fulfilled → Completed)
- Blood group matching algorithm
- Request expiration management

#### 🚑 Ambulance Module
- Ambulance owner registration & verification
- Three-tier approval workflow (Owner → Moderator → Admin)
- Per-kilometer fare calculation
- Real-time availability tracking
- Public search by location

#### 🏥 Hospital Directory
- Hospital registration & verification
- Facility information (ICU, Blood Bank, Emergency)
- Hospital-Ambulance association
- Public search functionality
- Photo gallery support

#### 💬 Live Support System
- Guest chat without authentication
- Real-time messaging with support agents
- Typing indicators & file uploads
- Ticket system for ticket support
- Chat history & archive

#### 📊 Admin Panel (FilamentPHP)
- Dashboard with 9+ key metrics
- User management with suspension capabilities
- Blood request workflow management
- Approval queues for ambulances & hospitals
- Email/WhatsApp notification logs
- Comprehensive reporting & audit logs

#### 🤖 Automation
- Cron jobs for:
  - Receiver account expiration (every minute)
  - Notification queue processing (every 5 minutes)
  - Request expiration (every hour)
  - Eligibility recalculation (daily)
  - Database backups (daily)

## 🛠 Technology Stack

| Component | Technology |
|-----------|-----------|
| Backend | Laravel 11 |
| Language | PHP 8.3 |
| Admin Panel | FilamentPHP v3 |
| Database | MySQL 8 |
| Queue | Redis |
| Real-time | Laravel Reverb |
| Notifications | Email, WhatsApp API, Firebase |
| Storage | S3 Compatible |
| Authentication | Laravel Sanctum |

## 📋 System Requirements

- PHP 8.3+
- Laravel 11
- MySQL 8.0+
- Redis 6+
- Node.js 18+ (for Filament assets)

## 🚀 Installation

### 1. Clone Repository
```bash
git clone https://github.com/shohan11223/bloodconnect-bangladesh.git
cd bloodconnect-bangladesh
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Environment
Edit `.env` with your settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bloodconnect_bangladesh
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=127.0.0.1
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password

WHATSAPP_API_KEY=your_whatsapp_api_key
FIREBASE_API_KEY=your_firebase_api_key

AWS_ACCESS_KEY_ID=your_s3_access_key
AWS_SECRET_ACCESS_KEY=your_s3_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name
```

### 5. Database Setup
```bash
php artisan migrate
php artisan seed:run
```

### 6. Build Assets
```bash
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
# In another terminal
php artisan queue:work
# In another terminal
php artisan reverb:start
```

## 📱 Default Login Credentials

### Super Admin
- **Email:** admin@bloodconnect.bd
- **Password:** password

### Moderator
- **Email:** moderator@bloodconnect.bd
- **Password:** password

### Test Donor
- **Email:** donor@bloodconnect.bd
- **Password:** password

## 📂 Project Structure

```
bloodconnect-bangladesh/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Donor.php
│   │   ├── Receiver.php
│   │   ├── BloodRequest.php
│   │   ├── Ambulance.php
│   │   └── Hospital.php
│   ├── Filament/
│   │   ├── Resources/
│   │   └── Pages/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Jobs/
│   ├── Notifications/
│   ├── Policies/
│   └── Actions/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   └── lang/
│       └── bn/ (Bangla translations)
├── routes/
│   ├── web.php
│   └── api.php
└── storage/
    └── logs/
```

## 🔐 Security Features

- ✅ CSRF Protection
- ✅ Rate Limiting
- ✅ Two-Factor Authentication (2FA) ready
- ✅ Activity Logging & Audit Trails
- ✅ Password Hashing (bcrypt)
- ✅ SQL Injection Prevention
- ✅ XSS Protection

## 🌍 Localization

- **Language:** 100% Bangla UI
- **Character Encoding:** UTF-8
- **Date Format:** Bengali calendar support
- **Phone Format:** Bangladesh (+880) format

## 📞 API Endpoints

### Authentication
- `POST /api/auth/register`
- `POST /api/auth/login`
- `POST /api/auth/logout`
- `GET /api/auth/user`

### Blood Requests
- `GET /api/blood-requests`
- `POST /api/blood-requests`
- `GET /api/blood-requests/{id}`
- `PATCH /api/blood-requests/{id}`
- `POST /api/blood-requests/{id}/accept`

### Donors
- `GET /api/donors`
- `POST /api/donors/register`
- `GET /api/donors/{id}`

### Ambulances
- `GET /api/ambulances`
- `GET /api/ambulances/search`

### Hospitals
- `GET /api/hospitals`
- `GET /api/hospitals/search`

## 📞 Support

For issues or feature requests, please create an issue on GitHub.

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👨‍💻 Author

**Shohan** - [GitHub](https://github.com/shohan11223)

---

**Last Updated:** 2026-06-05
**Version:** 1.0.0
