<?php var_dump($data) ?>

<div class="functions">
    <div class="actions">
        <input id="add_application_btn" class="item" type="button" value="Новая запись">
    </div>
</div>

<div id="add_application_modal" class="modal hidden">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Добавить запись пациента</h3>
                <a href="" title="Close" class="close">×</a>
            </div>
            <div class="modal-body">
                <form id="add_patient_modal" class="general-form" action="<?= app()->route->getUrl("/applications/patient?id=$id") ?>" method="POST">
                    <div class="inputs">
                        <select class="item" name="doctor">
                            <?php foreach($doctors as $doctor) { ?>
                                <option value="<?=$doctor['person_id']?>"><?=$doctor['specialization']?></option>
                            <?php } ?>
                            <input class="item" type="date" name="date_of_application">
                        </select>
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