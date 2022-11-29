<?php
require 'authController.php';
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style type="text/css">
    #regiration_form fieldset:not(:first-of-type) {
        display: none;
    }
    </style>
    <link rel="stylesheet" href="register/style.css">
    <title>Voter Registeration</title>
</head>

<body>
    <div class="container">

        <form id="regiration_form" action="register.php" method="post" enctype="multipart/form-data">
            <fieldset>



                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <!-- displaying errors -->


                    <?php if (count($errors) > 0) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                        <li> <?php echo $error;  ?></li>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- end of error -->


                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" placeholder="Enter your name" name="fullname"
                                value="<?php echo $fullname ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" placeholder="Enter your birth date" name='dob' value="<?php echo $dob ?>"
                                required>
                        </div>



                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" placeholder="Enter mobile number" name="phone"
                                value="<?php echo $phone?>" required>
                        </div>

                        <div class="input-field">
                            <label>Gender</label>

                            <select id="gender" name="gender1" value="<?php echo $gender?>">
                                <option disabled selected>Select your gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option Value="Others">Others</option>
                            </select>
                        </div>



                        <div class="input-field">
                            <label>Fathers name</label>
                            <input type="text" placeholder="Fathers name" name="fathername"
                                value="<?php echo $fathername?>" required>
                        </div>
                        <div class="input-field">
                            <label>Citzenship type</label>
                            <select id="citztype" name="citztype">
                                <option disabled selected>Select your citizenship type</option>
                                <option value="By descent"> Citizen by descent</option>
                                <option value="by birth">Citizenship by birth</option>
                                <option Value="other">Naturalised citizenship</option>

                            </select>

                        </div>

                        <div class="input-field">
                            <label>Citzenship Number</label>
                            <input type="text" placeholder="Enter Citzenship number" name="citznum"
                                value="<?php echo $citznum?>" required>
                        </div>



                        <div class="input-field">
                            <label> Citzenship Issued district</label>
                            <input type="text" placeholder="Enter your  citzenship issued district" name="idistrict"
                                value="<?php echo $idistrict ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Issued Date</label>
                            <input type="date" placeholder="Enter your issued date" name="idate"
                                value="<?php echo $idate ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Your photo(passport size)</label>
                            <input type="file" name="pphoto" required value="<?php echo $file1 ?>">
                        </div>
                        <div class="input-field">
                            <label>citzenship photo</label>
                            <input type="file" name="citzphoto" placeholder="" required value="<?php echo $file2 ?>">
                        </div>

                        <div class="input-field">

                        </div>

                    </div>

                </div>
                <input type="button" name="data[password]" class="next btn btn-info" value="Next" />



            </fieldset>

            <fieldset>

                <div class="details address">
                    <span class="title">Address Details</span>


                    <!-- displaying errors -->

                    <?php if (count($errors) > 0) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                        <li> <?php echo $error;  ?></li>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>


                    <!-- end of error -->

                    <div class="fields">
                        <div class="input-field">
                            <label>Nationality</label>
                            <input type="text" placeholder="Enter nationality" value="Nepali" readonly>
                        </div>

                        <div class="input-field">
                            <label>State</label>
                            <input type="text" placeholder="Enter your state" name="state" value="<?php echo $state ?>"
                                required>
                        </div>

                        <div class="input-field">
                            <label>District</label>
                            <input type="text" placeholder="Enter your district" name="district"
                                value="<?php echo $district ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Municipality</label>
                            <input type="text" placeholder="Enter municipality" name="municipality"
                                value="<?php echo $municipality ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Ward Number</label>
                            <input type="number" placeholder="Enter ward number" name="ward" value="<?php echo $ward ?>"
                                required>
                        </div>
                        <div class="input-field">
                            <label>Street, Tole</label>
                            <input type="text" placeholder="Enter street or tole" name="tole"
                                value="<?php echo $tole?>">
                        </div>
                    </div>
                </div>

                <div class="details family">
                    <span class="title">Account Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" placeholder="Enter your Email address" name="email"
                                value="<?php echo $email ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" placeholder="Enter your password" name="password"
                                value="<?php echo $password ?>" required>
                        </div>

                        <div class="input-field">
                            <label>confirm password</label>
                            <input type="password" placeholder="Retype your password" name="repassword"
                                value="<?php echo $passwordconf ?>" required>
                        </div>



                    </div>
                </div>

                <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                <input type="submit" name="submit1" class="submit btn btn-success" value="register" id="submit_data" />
            </fieldset>
        </form>
    </div>
</body>

</html>
<script type="text/javascript">
$(document).ready(function() {
    var current = 1,
        current_step, next_step, steps;
    steps = $("fieldset").length;
    $(".next").click(function() {
        current_step = $(this).parent();
        next_step = $(this).parent().next();
        next_step.show();
        current_step.hide();

    });
    $(".previous").click(function() {
        current_step = $(this).parent();
        next_step = $(this).parent().prev();
        next_step.show();
        current_step.hide();

    });

});
</script>