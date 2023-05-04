<?= var_dump($_SESSION) ?>
<main class="admin">
    <div class="container">

        <div class="functions">
            <div class="filters">
                <form id="search_form" action="/">
                    <input class="item" type="text" name="name" placeholder="Имя">
                    <input class="item" type="text" name="surname" placeholder="Фамилия">
                    <input class="item" type="text" name="patronymic" placeholder="Отчество">
                    <input id="search_btn" class="item" type="submit" value="Найти">
                </form>
            </div>

            <div class="actions">
                <?php if($_SESSION['role'] === 1) { ?>
                    <input id="add_employee_btn" class="item" type="button" value="Новый сотрудник">
                <?php } ?>

                <?php if($_SESSION['role'] === 5) { ?>
                    <input id="add_patient_btn" class="item" type="button" value="Новый пациент">
                <?php } ?>
            </div>
        </div>

        <div class="tabs">
            <?php if($_SESSION['role'] === 1 || $_SESSION['role'] === 2) { ?>
                <input id="employees_tab" class="item active" type="button" value="Работники">
            <?php } ?>

            <?php if($_SESSION['role'] === 5 || $_SESSION['role'] === 2 || $_SESSION['role'] === 3) { ?>
                <input id="patients_tab" class="item" type="button" value="Пациенты">
            <?php } ?>
        </div>

        <div class="list-wrapper">
            <?php if($_SESSION['role'] === 1 || $_SESSION['role'] === 2) { ?>
                <div id="table_title" class="title">Работники</div>
            <?php } else if($_SESSION['role'] === 3 || $_SESSION['role'] === 5) { ?>
                <div id="table_title" class="title">Пациенты</div>
            <?php } ?>
            <table class="table">
                <thead>
                <tr>
                <?php if($_SESSION['role'] === 1 || $_SESSION['role'] === 2) { ?>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Отчество</th>
                    <th>Дата рождения</th>
                    <th>Должность</th>
                    <th>Специализация</th>
                    <th>Отделение</th>
                    <th>Кабинет</th>
                    <th>Статус</th>
                    <th>Действие</th>
                <?php } else if($_SESSION['role'] === 3 || $_SESSION['role'] === 5) { ?>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Отчество</th>
                    <th>Дата рождения</th>
                    <th>Статус</th>
                    <th>Действие</th>
                <?php } ?>
                </tr>
                </thead>
                <tbody>

                <?php foreach($list as $person) { ?>
                    <tr>
                        <?php foreach($person as $key => $value) { ?>
                            <?php if($key !== 'id') { ?>
                                <td>
                                    <input type="hidden" value="<?= $key ?>">
                                    <?= (empty($value))? 'Отсутствует': $value ?>
                                </td>
                            <?php } else { ?>
                                <td class="hidden">
                                    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>">
                                </td>
                            <?php } ?>
                        <?php } ?>
                        <td class="action_cell">
                            <a href="/" class="edit">Редактировать</a>
                            <?php if(in_array($_SESSION['role'], [5, 3])) { ?>
                                <a class="application" href="<?= app()->route->getUrl('/applications/patient')."?id={$person['id']}" ?>">Записи</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>

        <div id="add_employee_modal" class="modal hidden">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Добавить нового сотрудника</h3>
                        <a href="" title="Close" class="close">×</a>
                    </div>
                    <div class="modal-body">
                        <form id="add_employee_form" class="general-form" action="/">
                            <div class="inputs">
                                <input class="item" type="text" name="login" placeholder="login">
                                <input class="item" type="password" name="password" placeholder="password">
                                <input class="item" type="text" name="name" placeholder="name">
                                <input class="item" type="text" name="surname" placeholder="surname">
                                <input class="item" type="text" name="patronymic" placeholder="patronymic">
                                <input class="item" type="date" name="date_of_birth">

                                <select id="select_role" class="item" name="role_id">
                                    <?php foreach($roles_list as $role) { ?>
                                        <option value="<?=$role->id?>"><?=$role->name?></option>
                                    <?php } ?>
                                </select>

                                <input class="item" type="text" name="specialization" placeholder="specialization">

                                <select id="select_department" class="item" name="department_id">
                                    <?php foreach($departments_list as $department) { ?>
                                        <option value="<?=$department->id?>"><?=$department->name?></option>
                                    <?php } ?>
                                    <option value="0">Отсутствует</option>
                                </select>

                                <input class="item" type="text" name="cabinet" placeholder="cabinet">
                            </div>

                            <div class="buttons">
                                <input class="item accept" type="button" value="Принять">
                                <input class="item cancel" type="button" value="Отменить">
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- modal-dialog -->
        </div> <!-- add_employee_modal -->

        <?php if($_SESSION['role'] === 5) { ?>
            <div id="add_patient_modal" class="modal hidden">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Добавить нового пациента</h3>
                            <a href="" title="Close" class="close">×</a>
                        </div>
                        <div class="modal-body">
                            <form id="add_patient_modal" class="general-form" action="/">
                                <div class="inputs">
                                    <input class="item" type="text" name="name" placeholder="name">
                                    <input class="item" type="text" name="surname" placeholder="surname">
                                    <input class="item" type="text" name="patronymic" placeholder="patronymic">
                                    <input class="item" type="date" name="date_of_birth">
                                </div>

                                <div class="buttons">
                                    <input class="item accept" type="button" value="Принять">
                                    <input class="item cancel" type="button" value="Отменить">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>