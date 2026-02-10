# إعداد WhatsApp API مجاني

## الحل المجاني الأول: WhatsApp Web API باستخدام Node.js

### المتطلبات:
- Node.js مثبت على السيرفر
- رقم واتساب عادي (ليس Business)
- كروم أو كروميوم

### خطوات الإعداد:

#### 1. إنشاء خدمة WhatsApp منفصلة
```bash
# في مجلد منفصل
mkdir whatsapp-service
cd whatsapp-service
npm init -y
npm install whatsapp-web.js qrcode-terminal express cors
```

#### 2. إنشاء ملف server.js
```javascript
const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');
const cors = require('cors');

const app = express();
app.use(express.json());
app.use(cors());

const client = new Client({
    authStrategy: new LocalAuth()
});

client.on('qr', (qr) => {
    console.log('امسح QR Code بهاتفك:');
    qrcode.generate(qr, {small: true});
});

client.on('ready', () => {
    console.log('✅ WhatsApp API جاهز للاستخدام!');
});

// API endpoint لإرسال الرسائل
app.post('/send-message', async (req, res) => {
    try {
        const { phone, message } = req.body;
        
        // تنسيق رقم الهاتف
        const formattedPhone = phone.replace(/[^0-9]/g, '') + '@c.us';
        
        await client.sendMessage(formattedPhone, message);
        
        res.json({ 
            success: true, 
            message: 'تم إرسال الرسالة بنجاح' 
        });
    } catch (error) {
        res.json({ 
            success: false, 
            error: error.message 
        });
    }
});

app.listen(3001, () => {
    console.log('WhatsApp Service running on port 3001');
});

client.initialize();
```

#### 3. تشغيل الخدمة
```bash
node server.js
# امسح QR Code بهاتفك
```

### تحديث Laravel للاستخدام

#### 4. تحديث WhatsAppService في Laravel
