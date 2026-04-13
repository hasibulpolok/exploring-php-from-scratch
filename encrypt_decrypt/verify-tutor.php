<?php
// =========================
// SAMPLE DATA
// =========================
$username = "admin";
$password = "1234";
$data = "Hello World";

// =========================
// HASHING
// =========================
$md5 = md5($password);

$sha1 = hash("sha1", $data);
$sha224 = hash("sha224", $data);
$sha256 = hash("sha256", $data);
$sha384 = hash("sha384", $data);
$sha512 = hash("sha512", $data);

// Extra
$ripemd = hash("ripemd160", $data);
$whirlpool = hash("whirlpool", $data);
$crc32 = hash("crc32", $data);

// Encryption (not hash)
$encrypted = base64_encode($data);
$decrypted = base64_decode($encrypted);

// Best security
$secure = password_hash($password, PASSWORD_DEFAULT);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Single Page PHP Tutorial</title>

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
            width: 85%;
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

        .box {
            background: #f5f5f5;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            word-break: break-all;
        }

        h2 {
            color: #333;
        }

        .q {
            font-weight: bold;
            color: #1e88e5;
        }

        .a {
            margin-top: 5px;
            color: #444;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>📘 Full PHP Encryption Tutorial (Single Page)</h2>
</div>

<div class="container">

    <!-- Q1 -->
    <div class="card">
        <div class="q">❓ Q1: Encryption কী?</div>
        <div class="a">
            Encryption হলো data hide করা যা পরে আবার decode করা যায়।
        </div>

        <div class="box">
            Original: <?php echo $data; ?><br>
            Encrypted: <?php echo $encrypted; ?><br>
            Decrypted: <?php echo $decrypted; ?>
        </div>
    </div>

    <!-- Q2 -->
    <div class="card">
        <div class="q">❓ Q2: Hashing কী?</div>
        <div class="a">
            Hashing হলো one-way process (ফিরানো যায় না)।
        </div>

        <div class="box">
            MD5 Password: <?php echo $md5; ?>
        </div>
    </div>

    <!-- Q3 -->
    <div class="card">
        <div class="q">❓ Q3: SHA কী?</div>
        <div class="a">
            SHA হলো secure hashing algorithm।
        </div>

        <div class="box">
            SHA1: <?php echo $sha1; ?><br><br>
            SHA224: <?php echo $sha224; ?><br><br>
            SHA256: <?php echo $sha256; ?><br><br>
            SHA384: <?php echo $sha384; ?><br><br>
            SHA512: <?php echo $sha512; ?>
        </div>
    </div>

    <!-- Q4 -->
    <div class="card">
        <div class="q">❓ Q4: Extra Hash Algorithms</div>
        <div class="box">
            RIPEMD160: <?php echo $ripemd; ?><br>
            Whirlpool: <?php echo $whirlpool; ?><br>
            CRC32: <?php echo $crc32; ?>
        </div>
    </div>

    <!-- Q5 -->
    <div class="card">
        <div class="q">❓ Q5: Best Security কী?</div>
        <div class="a">
            password_hash + password_verify হলো best method 🔐
        </div>

        <div class="box">
            Hash: <?php echo $secure; ?>
        </div>

        <div class="box">
            <?php
            if(password_verify("1234",$secure)){
                echo "✔ Login Success";
            } else {
                echo "❌ Wrong Password";
            }
            ?>
        </div>
    </div>

    <!-- Q6 -->
    <div class="card">
        <div class="q">❓ Q6: MD5 কি secure?</div>
        <div class="a">
            ❌ না, MD5 খুব weak এবং easy to hack।
        </div>
    </div>

</div>

</body>
</html>