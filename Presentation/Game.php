<?php

declare(strict_types=1);
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset=utf-8>
    <link rel="stylesheet" type="text/css" href="css.css">
    <title>Sonic &amp; Sega All-Stars Battle Royale</title>
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <img class="logo" src="images/logo.png" alt="logo"><br>
            <?php
            if (!isset($_SESSION["start"])) {
                print "<center><h3>Please flip a coin to see which player may start.<br>
            Sonic = Player 1 / Tails = Player 2</h3></center>";
            }
            if ($orderAttack === 1) {
                print "<center><h3>Characters have equal speed!<br>
        Flip a coin to see who may attack first.<br>
        Sonic = Player 1 / Tails = Player 2</h3></center>";
            }
            ?>
            <table>
                <tr>
                    <td colspan=5>
                        <h2><?php print $_SESSION["usernameP1"] ?>:
                            <?php if (!isset($_SESSION["start"])) {
                                print 'Please wait';
                            } else {
                                if (isset($_SESSION["turn"]) && $_SESSION["turn"] === 1) {
                                    print 'Your turn';
                                } elseif ($_SESSION["turn"] === 2) {
                                    print 'Please wait';
                                }
                            }
                            ?></h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="textdeck">Deck</p>
                    </td>
                    <td colspan=4></td>
                </tr>
                <td class="deck"></td>
                <?php $cardSvc->buildPlayingCards(1); ?>
                <tr>
                    <td>
                        <p class="textdeck">Cards: <?php print $cardSvc->countCardsInDeck(1); ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan=5>
                        <?php
                        if ($coin === 1) {
                            print "<img class=coin src=images/coinheads.png alt=coin><br>";
                        } else {
                            print "<img class=coin src=images/cointails.png alt=coin><br>";
                        }
                        if (!isset($_SESSION["start"])) {
                            print "<center><a class=button href=game.php?action=flipStart>Flip Coin</a></center><br>";
                        } elseif ($orderAttack === 1) {
                            print "<center><a class=button href=game.php?action=flipSpeed>Flip Coin</a></center><br>";
                        } else {
                            print "<center><a class=button href=game.php?action=flip>Flip Coin</a></center><br>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan=5>
                        <h2><?php print $_SESSION["usernameP2"] ?>:
                            <?php if (!isset($_SESSION["start"])) {
                                print 'Please wait';
                            } else {
                                if (isset($_SESSION["turn"]) && $_SESSION["turn"] === 2) {
                                    print 'Your turn';
                                } elseif ($_SESSION["turn"] === 1) {
                                    print 'Please wait';
                                }
                            }
                            ?></h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="textdeck">Deck</p>
                    </td>
                    <td colspan=4></td>
                </tr>
                <td class="deck"></td>
                <?php $cardSvc->buildPlayingCards(2); ?>
                <tr>
                    <td>
                        <p class="textdeck">Cards: <?php print $cardSvc->countCardsInDeck(2); ?></p>
                    </td>
                </tr>
            </table>
            <center><a class="button" href="game.php?reset=1">Reset Game</a> <a class="button" href="logout.php?action=logout">Stop Game</a></center><br><br>
        </div>
    </div>
</body>

</html>