<!-- Francesco Filippini -->
<article>       <!-- TODO: Warning: article lacks heading  -->
    <ul>
    <?php
        foreach ($db->notificationsGet() as $notification):
            echo "<li>".$notification["message"]."</li>";  //TODO $notification["EkIdUserSrc"] potrei usarlo per linkare al profilo di chi ha inviato la notifica
        endforeach;
    ?>
    </ul>
</article>