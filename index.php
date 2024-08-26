<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task5</title>
    <link rel="stylesheet" href="main.css" />
    

</head>


<body>
    <div>
        <div>



            <form action="db.php" method="POST" id="form">
                <h3 id="form">Форма</h3>

                <?php
                if (!empty($messages)) {
                    print ('<div id="messages">');

                    foreach ($messages as $message) {
                        print ($message);
                    }
                    print ('</div>');
                }
                ?>



                <div>
                    <label for="validationCustom01" >Фамилия Имя Отчество:</label>


                    <input type="text" placeholder="ФИО" name="fio" <?php if ($errors['fio']) {
                        print 'class="error"';
                    } ?> value="<?php print $values['fio']; ?>" />
                </div>






                <div>
                    <label for="validationCustomUsername">Телефон:
                    </label>
                    <div>
                         <input type="text" placeholder="Введите ваш номер" name="tel"
                         <?php if ($errors['tel']) {
                        print 'class="error"';
                    } ?> value="<?php print $values['tel']; ?>" />

                    </div>
                </div>





                <div>
                    <label for="validationCustomUsername">E-mail:
                    </label>
                    <div>
                    <input type="text" rounded-pill" placeholder="Введите ваш E-mail" name="email"
        <?php if (isset($_COOKIE['email_error']) && $_COOKIE['email_error'] === '1') {
            print 'class="error"';
        } ?> value="<?php print isset($_COOKIE['email_value']) ? $_COOKIE['email_value'] : $values['email']; ?>" />

                    </div>
                </div>





                <div>
                    <label>
                        Дата рождения:<br />
                        <input placeholder="2004-07-14" type="date" name="date" <?php if ($errors['date']) {
                            print 'class="error"';
                        } ?>   value="<?php print $values['date']; ?>" />
                    </label>
                </div>





                <div>
                    <p>Выберите ваш пол:<br /></p>
                    <div>


                        <input type="radio" name="someGroupName" value="Женский"
                            id="someRadioId1" <?php echo isset($_COOKIE['someGroupName_value']) && $_COOKIE['someGroupName_value'] === 'Женский' ? 'checked' : ''; ?>>

                        <label for="someRadioId1">Женский</label>
                    </div>
                    <div>
                        <input type="radio" name="someGroupName" value="Мужской"
                            id="someRadioId2" <?php echo isset($_COOKIE['someGroupName_value']) && $_COOKIE['someGroupName_value'] === 'Мужской' ? 'checked' : ''; ?>>
                        <label for="someRadioId2">Мужской</label>
                    </div>
                </div>






                <div>
                    <label for="validationCustom04">Любимый язык программирования</label>
                    <select id="validationCustom04" multiple name="language[]">
                        <option selected="" disabled="" value="">Выберете</option>
                        <option value="1" <?php if(isset($_COOKIE['language_value']) && in_array('1', unserialize($_COOKIE['language_value']))) { echo 'selected'; } ?>>Pascal</option>
                        <option value="2" <?php if(isset($_COOKIE['language_value']) && in_array('2', unserialize($_COOKIE['language_value']))) { echo 'selected'; } ?>>C</option>
                        <option value="3" <?php if(isset($_COOKIE['language_value']) && in_array('3', unserialize($_COOKIE['language_value']))) { echo 'selected'; } ?>>C++</option>
                        <option value="4" <?php if(isset($_COOKIE['language_value']) && in_array('4', unserialize($_COOKIE['language_value'])))  {echo 'selected';}  ?>>JavaScript</option>
                        <option value="5" <?php if(isset($_COOKIE['language_value']) && in_array('5', unserialize($_COOKIE['language_value'])))  {echo 'selected';}  ?>>PHP</option>
                        <option value="6" <?php if(isset($_COOKIE['language_value']) && in_array('6', unserialize($_COOKIE['language_value'])))  {echo 'selected';} ?>>Python</option>
                        <option value="7" <?php if(isset($_COOKIE['language_value']) && in_array('7', unserialize($_COOKIE['language_value'])))  {echo 'selected';}  ?>>Java</option>
                        <option value="8" <?php if(isset($_COOKIE['language_value']) && in_array('8', unserialize($_COOKIE['language_value'])))  {echo 'selected';}  ?>>Haskell</option>
                        <option value="9" <?php if(isset($_COOKIE['language_value']) && in_array('9', unserialize($_COOKIE['language_value'])))  {echo 'selected';} ?>>Clojure</option>
                        <option value="10" <?php if(isset($_COOKIE['language_value']) && in_array('10', unserialize($_COOKIE['language_value'])))   {echo 'selected';} ?>>Prolog</option>
                        <option value="11" <?php if(isset($_COOKIE['language_value']) && in_array('11', unserialize($_COOKIE['language_value'])))  {echo 'selected';} ?>>Scala</option>
                    </select>
                    <div>
                    </div>
                </div>




                <div>
                    <label>
                        Биография:<br />

                        <textarea placeholder="Напишите свою биографию" name="Biographi"
                            <?php if (isset($_COOKIE['Biographi_error']) && $_COOKIE['Biographi_error'] === '1') {
                                print 'class="error"';
                            } ?>><?php echo isset($_COOKIE['Biographi_value']) ? $_COOKIE['Biographi_value'] : ''; ?></textarea>
                    </label>
                </div>





                <div>
                    С контрактом:
                    <div>
                        <input type="checkbox" <?php if (isset($_COOKIE['checkt_error']) && $_COOKIE['checkt_error'] === '1') {
                            print 'class="error"';
                        } ?> value="Ознакомлен" id="invalidCheck" name="checkt"
                        <?php if (isset($_COOKIE['checkt_value']) && $_COOKIE['checkt_value'] === 'Ознакомлен') {
                            print 'checked';
                        } ?> />
                        <label for="invalidCheck">
                            Ознакомлен (а)
                        </label>
                        <div></div>
                    </div>
                </div>
                <div>
                    <button name="sumbit">Сохранить</button>
                </div>
            </form>

        </div>

    </div>
</body>

</html>