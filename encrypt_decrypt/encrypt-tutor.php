<?php
// =========================
// SAMPLE DATA
// =========================
$username = "admin";
$password = "1234";
$data = "Hello World";

// =========================
// HASH & ENCRYPTION
// =========================
$md5_pass = md5($password);

$sha1 = hash("sha1", $data);
$sha224 = hash("sha224", $data);
$sha256 = hash("sha256", $data);
$sha384 = hash("sha384", $data);
$sha512 = hash("sha512", $data);

$ripemd = hash("ripemd160", $data);
$whirlpool = hash("whirlpool", $data);
$crc32 = hash("crc32", $data);

// Encryption (not hash)
$encrypted = base64_encode($data);
$decrypted = base64_decode($encrypted);

// Secure password
$secure_hash = password_hash($password, PASSWORD_DEFAULT);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Full Encryption Tutorial (Bangla)</title>

    <style>
        body {
            font-family: Arial;
            background: #eef2f7;
            margin: 0;
        }

        .header {
            background: #1e88e5;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .q {
            font-weight: bold;
            color: #333;
        }

        .a {
            margin-top: 5px;
            color: #444;
        }

        .box {
            padding: 10px;
            margin: 8px 0;
            border-radius: 8px;
            background: #f5f5f5;
            word-wrap: break-word;
        }

        .md5 { background: #ffebee; }
        .sha { background: #e3f2fd; }
        .enc { background: #e8f5e9; }
        .secure { background: #fff3e0; }
    </style>
</head>

<body>

<div class="header">
    <h2>🔐 Encryption + Hashing Full Tutorial (Bangla)</h2>
</div>

<div class="container">

    <!-- Q1 -->
    <div class="card">
        <div class="q">❓ Q1: Encryption কী?</div>
        <div class="a">
            Encryption হলো data কে এমনভাবে পরিবর্তন করা যাতে কেউ বুঝতে না পারে,
            কিন্তু পরে আবার আগের অবস্থায় ফিরিয়ে আনা যায়।
        </div>

        <div class="box enc">
            🔐 Example:<br>
            Original: <?php echo $data; ?><br>
            Encrypted: <?php echo $encrypted; ?><br>
            Decrypted: <?php echo $decrypted; ?>
        </div>
    </div>

    <!-- Q2 -->
    <div class="card">
        <div class="q">❓ Q2: Hashing কী?</div>
        <div class="a">
            Hashing হলো one-way process, যেটা আবার reverse করা যায় না।
        </div>

        <div class="box md5">
            MD5 Password Hash:<br>
            <?php echo $md5_pass; ?>
        </div>
    </div>

    <!-- Q3 -->
    <div class="card">
        <div class="q">❓ Q3: SHA কী?</div>
        <div class="a">
            SHA (Secure Hash Algorithm) হলো শক্তিশালী hashing system।
        </div>

        <div class="box sha">
            SHA1: <?php echo $sha1; ?><br><br>
            SHA224: <?php echo $sha224; ?><br><br>
            SHA256: <?php echo $sha256; ?><br><br>
            SHA384: <?php echo $sha384; ?><br><br>
            SHA512: <?php echo $sha512; ?>
        </div>
    </div>

    <!-- Q4 -->
    <div class="card">
        <div class="q">❓ Q4: Extra Hash Algorithms কী কী?</div>
        <div class="a">
            PHP তে আরও কিছু hashing algorithm আছে।
        </div>

        <div class="box">
            RIPEMD160: <?php echo $ripemd; ?><br>
            Whirlpool: <?php echo $whirlpool; ?><br>
            CRC32: <?php echo $crc32; ?>
        </div>
    </div>

    <!-- Q5 -->
    <div class="card">
        <div class="q">❓ Q5: Best Security কোনটা?</div>
        <div class="a">
            Real project এ password_hash() ব্যবহার করতে হয়।
        </div>

        <div class="box secure">
            Secure Hash:<br>
            <?php echo $secure_hash; ?><br><br>

            Verify Result:
            <?php
            if(password_verify("1234",$secure_hash)){
                echo "✔ Login Success";
            } else {
                echo "❌ Failed";
            }
            ?>
        </div>
    </div>

    <!-- Q6 -->
    <div class="card">
        <div class="q">❓ Q6: MD5 কি secure?</div>
        <div class="a">
            না ❌ MD5 এখন খুব weak, সহজেই hack করা যায়।
        </div>
    </div>

</div>

</body>
</html>