<?php if($_SESSION['role'] === 5 || (in_array($_SESSION['role'], [2, 3, 4]) && $current_uri === '/applications/doctor')) { ?>
    <div class="functions">
        <div class="actions">
            <input id="add_application_btn" class="item" type="button" value="Новая запись">
            <form action="<?= app()->route->getUrl('/add_file') ?>"
                  method="post"
                  enctype="multipart/form-data">
                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
                <input type="file" name="files[]" multiple>
                <input type="submit" value="Отправить">
            </form>
        </div>
    </div>
<?php } ?>

<div class="list-wrapper">
    <div id="table_title" class="title">Записи</div>
    <table class="table">
        <thead>
        <tr>
            <?php if(in_array($_SESSION['role'], [2, 3, 4]) && empty($list)) { ?>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
                <th>Дата приема</th>
                <th>Диагноз</th>
            <?php } else { ?>
                <th>Врач</th>
                <th>Кабинет</th>
                <th>Дата приема</th>
                <th>Диагноз</th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>

        <?php foreach($applications as $application) { ?>
            <?php if(in_array($_SESSION['role'], [2, 3, 4]) && empty($list)) { ?>
                <tr>
                    <td><?= $application['patient']['person']['name'] ?></td>
                    <td><?= $application['patient']['person']['surname'] ?></td>
                    <td><?= $application['patient']['person']['patronymic'] ?></td>
                    <td><?= $application['date_of_application'] ?></td>
                    <?php if(!isset($application['diagnostic'])) { ?>
                        <td>
                            Не назначен <br>
                            <?php if(in_array($_SESSION['role'], [2, 3, 4]) && $current_uri === '/applications/doctor') { ?>
                                <form action="<?= app()->route->getUrl("/add/diagnostic") ?>" method="POST">
                                    <input type="hidden" name="application_id" value="<?=$application['id']?>">
                                    <input type="text" name="diagnostic" placeholder="Введите диагноз">
                                    <input type="submit" value="Назначить">
                                </form>
                            <?php } ?>
                        </td>
                    <?php } else { ?>
                        <td><?= $application['diagnostic'] ?></td>
                    <?php } ?>
                </tr>
            <?php } else { ?>
                <tr>
                    <td><?= $application['employee']['specialization'] ?></td>
                    <td><?= $application['employee']['cabinet'] ?></td>
                    <td><?= $application['date_of_application'] ?></td>
                    <td><?= $application['diagnostic']?? 'Не назначен' ?></td>
                </tr>
            <?php } ?>
        <?php } ?>

        </tbody>
    </table>
</div>

<div id="add_application_modal" class="modal hidden">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Добавить запись пациента</h3>
                <a href="" title="Close" class="close">×</a>
            </div>
            <div class="modal-body">
                <form id="add_patient_modal"
                      class="general-form"
                      action="<?= app()->route->getUrl($current_uri)."?id=$id" ?>"
                      method="POST">

                    <div class="inputs">
                        <?php if($current_uri === '/applications/doctor') { ?>
                            <select class="item" name="patient">
                                <?php foreach($patients as $patient) { ?>
                                    <option value="<?= $patient['person_id'] ?>">
                                        <?= $patient['person']['name']." " ?>
                                        <?= $patient['person']['surname']." " ?>
                                        <?= $patient['person']['patronymic'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input class="item" type="date" name="date_of_application">
                        <?php } else if($current_uri === '/applications/patient') { ?>
                            <select class="item" name="doctor">
                                <?php foreach($doctors as $doctor) { ?>
                                    <option value="<?=$doctor['person_id']?>">
                                        (<?=$doctor['specialization']?>)
                                        <?= $doctor['person']['name']." " ?>
                                        <?= $doctor['person']['surname']." " ?>
                                        <?= $doctor['person']['patronymic']?>
                                    </option>
                                <?php } ?>
                                <input class="item" type="date" name="date_of_application">
                            </select>
                        <?php } ?>
                    </div>

                    <div class="buttons">
                        <input class="item accept" type="submit" value="Принять">
                        <input id="cancel_modal" class="item cancel" type="button" value="Отменить">
                    </div>

                </form>
            </div>
        </div>
    </div> <!-- modal-dialog -->
</div> <!-- add_employee_modal -->