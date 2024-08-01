<div id="chatBox">
    <section id="chatList">
        <h2>Messagerie</h2>
        <?php
        foreach ($conversationsList as $entry) {
            $conversation = $entry['conversation'];
            $receiver = $entry['receiver'];
            ?>
            <a href="index.php?action=mailbox&idReceiver=<?= $conversation->getIdUser2() ?>">
                <figure class="chatlist--item">
                    <img src=<?= Utils::filepath($receiver->getAvatar(), true) ?> alt="avatar">
                    <figcaption>
                        <h4>
                            <?= $receiver->getUsername() ?>
                            <span><?= Utils::formatTimestamp($conversation->getTimestampLastMessage())?></span>
                        </h4>
                        <p><?= $conversation->getContentLastMessage() ?></p>

                    </figcaption>
                </figure>
            </a>
            <?php
        }

        ?>
    </section>
    <section id="chat">
        <h3>Conversation</h3>
    </section>

</div>