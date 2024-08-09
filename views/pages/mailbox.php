<div id="chatBox">
    <section id="chatList">
        <h2>Messagerie</h2>
        <?php
        if(!empty($conversationsList)){
            foreach ($conversationsList as $entry) {
                $conversation = $entry['conversation'];
                $receiver = $entry['receiver'];
                ?>
                <a href="index.php?action=mailbox&conversationId=<?= $conversation->getId() ?>">
                    <figure
                        class="chatlist--item <?= (isset($_GET["conversationId"]) && $conversation->getId() == $_GET["conversationId"]) ? "active" : null ?>">
                        <img src=<?= Utils::filepath($receiver->getAvatar(), true) ?> alt="avatar">
                        <figcaption>
                            <h4>
                                <?= $receiver->getUsername() ?>
                                <span><?= $conversation->getId() !== -1 ? Utils::formatTimestamp($conversation->getTimestampLastMessage()) : null ?></span>
                            </h4>
                            <p><?= $conversation->getContentLastMessage() ?></p>
                        </figcaption>
                    </figure>
                </a>
                <?php
            }
        }
        ?>
    </section>
    <section id="chat">
        <?php if (!empty($messages) || $messageReceiver ) { ?>
            <h3 class="font-semibold">
                <img src=<?= Utils::filepath($messageReceiver->getAvatar(), true) ?> alt="avatar">
                <?= $messageReceiver->getUsername() ?>
            </h3>
            <?php
            foreach ($messages as $message) {
                ?>
                <div
                    class="message <?= $message->getAuthorId() == $_SESSION['user']->getId() ? "own_message" : "received_message" ?>">
                    <h5>
                        <?= $message->getAuthorId() != $_SESSION['user']->getId() ?
                            '<img src=' . Utils::filepath($messageReceiver->getAvatar(), true) . ' alt="avatar">'
                            :
                            null ?>
                        <?= Utils::formatTimestamp($message->getCreatedAt()) ?>
                    </h5>
                    <p><?= $message->getContent() ?></p>
                </div>
                <?php
            } ?>

            <form action="index.php?action=sendMessage&idReceiver=<?= $messageReceiver->getId() ?>" method="post">
                <input placeholder="Tapez votre message ici" type="text" name="message" id="message">
                <button type="submit" data-idReceiver="<?= $messageReceiver->getId() ?>"
                    class="primary_button font-semibold">Envoyer</button>
                <?php
        } else {
            echo "<h2>Sélectionnez une conversation !</h2>";
        }
        ?>
    </section>

</div>