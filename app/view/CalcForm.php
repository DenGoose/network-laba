<?php
/* @var array $params */
?>
<?php if (isset($params['msg'])):?>
    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
        <h4 class="alert-heading">
            Ошибка:
        </h4>
        <p><?=$params['msg']?></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php else:?>
    <div class="alert alert-secondary alert-dismissible fade show mt-4" role="alert">
        <p>Разработать приложение, которое <strong>по заданному классу (А, В или С)</strong>, <strong>количеству подсетей N</strong> и
            <strong>максимальному количеству компьютеров M в подсети</strong> определяет маску для разбиения на
            подсети и список возможных IP-адресов подсетей.
        </p>
        <p>
            Если разбиение на подсети невозможно,
            приложение должно выдавать соответствующее сообщение об ошибке.
        </p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<form class="pt-4" style="max-width: 600px; width: 100%" method="post" action="/" enctype="multipart/form-data">
    <label for="input-class">
        Класс IP сети
    </label>
    <select name="class" id="input-class" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
        <option <?=(isset($params['form']['class']) && $params['form']['class'] == 'a') ? 'selected' : ''?> value="a">A (255.x.x.x)</option>
        <option <?=(isset($params['form']['class']) && $params['form']['class'] == 'b') ? 'selected' : ''?> value="b">B (255.255.x.x)</option>
        <option <?=(isset($params['form']['class']) && $params['form']['class'] == 'c') ? 'selected' : ''?> value="c">C (255.255.255.x)</option>
    </select>
    <label for="subnet-count">
        Количество подсетей
    </label>
    <input type="number" class="form-control" name="subnet-count" id="subnet-count" value="<?=$params['form']['subnet-count'] ?? 0?>">
    <label for="subnet-devices">
        Максимальное количество компьютеров
    </label>
    <input type="number" class="form-control" name="subnet-devices" id="subnet-devices" value="<?=$params['form']['subnet-devices'] ?? 0?>">
    <button type="submit" class="btn btn-dark mt-4">Посчитать</button>
</form>