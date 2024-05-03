<!-- Francesco Filippini -->
<article>
    <ul>
        <!-- TODO $notification["EkIdUserSrc"] potrei usarlo per linkare al profilo di chi ha inviato la notifica -->
        <?php foreach ($db->notificationsGet() as $notification): ?>
        <li><?php echo $notification['username'].' '.$notification['message'] ?></li>
        <?php endforeach; ?>
    </ul>
</article>