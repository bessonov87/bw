<?php
/**
 * @var \yii\web\View $this
 * @var array $options
 * @var int $shares
 */

\frontend\assets\SharerAsset::register($this);

?>

<div class="sharer">
    <div class="sharer-item sharer-white sharer-vk" data-service="vk" title="Поделиться во Вконтакте">
        <i class="fa fa-vk" aria-hidden="true"></i>
    </div>
    <div class="sharer-item sharer-white sharer-ok" data-service="ok" title="Поделиться в Одноклассниках">
        <i class="fa fa-odnoklassniki" aria-hidden="true"></i>
    </div>
    <div class="sharer-item sharer-white sharer-mr" data-service="mr" title="Поделиться в Mail.Ru">
        <strong>@</strong>
    </div>
    <div class="sharer-item sharer-white sharer-go" data-service="go" title="Поделиться в Google+">
        <i class="fa fa-google-plus" aria-hidden="true"></i>
    </div>
    <div class="sharer-item sharer-white sharer-fa" data-service="fa" title="Поделиться в Facebook">
        <i class="fa fa-facebook" aria-hidden="true"></i>
    </div>
    <div class="sharer-item sharer-white sharer-tw" data-service="tw" title="Поделиться в Twitter">
        <i class="fa fa-twitter" aria-hidden="true"></i>
    </div>
    <div class="sharer-item sharer-white sharer-fv" data-service="fv" title="Добавить в избранное">
        <i class="fa fa-star" aria-hidden="true"></i>
    </div>
    <?php
    if($shares > 0){
        echo '<div class="sharer-shares"><span class="shares-count">'.$shares.'</span></div>';
    }
    ?>
</div>
