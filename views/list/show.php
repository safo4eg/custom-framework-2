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
                <input id="add_employee_btn" class="item" type="button" value="Новый сотрудник">
                <input id="add_patient_btn" class="item" type="button" value="Новый пациент">
            </div>
        </div>

        <div class="tabs">
            <input id="employees_tab" class="item active" type="button" value="Работники">
            <input id="patients_tab" class="item" type="button" value="Пациенты">
        </div>

        <div class="list-wrapper">
            <div id="table_title" class="title">Работники</div>
            <table class="table">
                <thead>
                <tr>
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
                </tr>
                </thead>
                <tbody>

                <?php foreach($employees_list as $employee) { ?>
                    <tr>
                        <?php foreach($employee as $key => $value) { ?>
                            <?php if($key !== 'id') { ?>
                                <td>
                                    <input type="hidden" value="<?= $key ?>">
                                    <?= $value ?? 'Отсутствует' ?>
                                </td>
                            <?php } ?>
                        <?php } ?>
                        <td class="action_cell">
                            <a href="/" class="edit">Редактировать</a>
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
                        <form class="general-form" action="/">
                            <div class="inputs">
                                <input class="item" type="text" name="name" placeholder="name">
                                <input class="item" type="text" name="surname" placeholder="surname">
                                <input class="item" type="text" name="patronymic" placeholder="patronymic">
                                <input class="item" type="date" name="date_of_birth">
                                <input class="item" type="text" name="role" placeholder="role">
                                <input class="item" type="text" name="specialization" placeholder="specialization">
                                <input class="item" type="text" name="department" placeholder="department">
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

    </div>