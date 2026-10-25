
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px;
            background-color: white;
        }

        h3 {
            font-size: 18px;
            margin: 5px 0 10px 5px;
        }

        fieldset {
            background-color: #ddddff;
            border: 1px solid #aaaaaa;
            padding: 8px;
            margin: 0;
        }

        legend {
            font-weight: bold;
            padding: 0 5px;
        }

        .form-container {
            width: 400px;
            border: 1px solid #aaaaaa;
            padding: 8px;
            background-color: #eeeeff;
        }

        .field {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1px;
        }

        .field > label {
            width: 115px;
            text-align: right;
            margin-right: 6px;
            padding-top: 2px;
            flex-shrink: 0;
        }

        input[type="text"],
        input[type="password"] {
            width: 135px;
            height: 13px;
            box-sizing: border-box;
            font-size: 10px;
            padding: 1px 2px;
        }

        textarea {
            width: 110px;
            height: 32px;
            box-sizing: border-box;
            font-size: 10px;
            padding: 2px;
        }

        select {
            width: 115px;
            height: 14px;
            font-size: 10px;
        }

        .radio-group {
            display: flex;
            align-items: center;
        }

        .radio-group label {
            width: auto;
            text-align: left;
            margin-right: 5px;
            padding-top: 0;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin: 1px 3px 0 0;
        }

        .buttons {
            margin-left: 121px;
            margin-top: 2px;
        }

        input[type="submit"],
        input[type="reset"] {
            font-size: 9px;
            padding: 1px 5px;
        }
    </style>
</head>

<body>

    <h3>Register</h3>

    <div class="form-container">
        <form name="myForm" action="processData_form.php" method="POST">

            <fieldset>
                <legend>Person Details</legend>

                <div class="field">
                    <label for="surname">Surname</label>
                    <input type="text" id="surname" name="surname" size="31">
                </div>

                <div class="field">
                    <label for="email">Email address</label>
                    <input type="text" id="email" name="email" size="31">
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" size="31">
                </div>

                <div class="field">
                    <label for="address">Street Address</label>
                    <textarea id="address" name="address" rows="3" cols="22"></textarea>
                </div>

                <div class="field">
                    <label for="state">State</label>
                    <select id="state" name="state">
                        <option value="-1" selected>[Choose your state]</option>
                        <option value="1">Australian Capital Territory</option>
                        <option value="2">Queensland</option>
                        <option value="3">Victoria</option>
                        <option value="4">New South Wales</option>
                        <option value="5">Tasmania</option>
                        <option value="6">South Australia</option>
                        <option value="7">Western Australia</option>
                        <option value="8">Northern Territory</option>
                    </select>
                </div>

                <input type="hidden" name="country" value="Australia">

                <div class="field">
                    <label>Gender</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="sex" value="male">Male
                        </label>
                        <label>
                            <input type="radio" name="sex" value="female">Female
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label for="vegetarian">Vegetarian?</label>
                    <input type="checkbox" id="vegetarian" name="vegetarian" value="Yes">
                </div>

                <div class="buttons">
                    <input type="submit" value="Submit" name="submit">
                    <input type="reset" value="Reset" name="reset">
                </div>

            </fieldset>
        </form>
    </div>

</body>
</html>
