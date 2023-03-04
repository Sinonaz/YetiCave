<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($bets as $bet): ?>

            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= $bet["img"]; ?>" width="54" height="40" alt="<?= $bet["title"]; ?>">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?= $bet["id"]; ?>"><?= $bet["title"]; ?></a></h3>
                </td>
                <td class="rates__category">
                    <?= $bet["name_category"]; ?>
                </td>
                <td class="rates__timer">
                    <?php $res = get_time_left($bet["date_finish"]); ?>

                    <div class="timer timer--finishing"><?= "$res[0]:$res[1]:$res[3]"; ?></div>
                </td>
                <td class="rates__price">
                    <?= format_num($bet["price_bet"]); ?>
                </td>
                <td class="rates__time">
                    <?php $minute = get_minutes_past($bet["date_bet"]); ?>

                    <?= $minute . get_noun_plural_form($minute, " минута", " минуты", " минут") . " назад" ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>
</section>