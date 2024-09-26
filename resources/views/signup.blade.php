<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل</title>
    <!-- <link rel="stylesheet" href="css/leon.css"> -->
    <link rel="stylesheet" href="css/normalize.css">
</head>

<body>
    <div class="page">
        <header>
            <div>
                <h1 style="display: inline;">نبض</h1>
                <img src="{{ asset('storage/logo/logo.jpg') }}" alt="">
            </div>

        </header>
        <div class="buttons">
            <button id="seller">بائع</button>
            <button id="patient">مستخدم</button>
            <button id="doctor">طبيب</button>
            <span class="reg-span">لتسجيل حساب جديد اختر طريقة التسجيل ثم املأ المعلومات</span>
        </div>
        <a name="login" class="loginbtn" style="width: fit-content;padding: 2px 100px;"> لديك حساب سابق؟</a>

        <div class="forms" id="forms">
            <!-- begin doctor form -->
            <div class="doctor reg">
                <h2 id="doctorTitle">طبيب</h2>
                <form method="POST" enctype="multipart/form-data" action="/signup/doctorSignup" class="login"
                    id="regDoctor">
                    @csrf
                    <label for="full-name">الاسم الكامل</label>
                    <input type="text" id="full-name" name="fullname" value="{{ old('fullname') }}" required>
                    @error('fullname')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الاسم الذي ادخلته موجود مسبقا يرجى اعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror


                    <label for="email">البريد الالكتروني</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الحساب الذي ادخلته موجود مسبقا يرجى التأكد من حسابك واعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror


                    <label for="password">كلمة السر</label>
                    <input type="password" id="password" name="password" minlength="8" max="21" required>
                    @error('password')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                يجب ان تحتوي كلمة السر على 8 خانات على الاقل واقصى حجم 21 وان تحتوي على حرف واحد على الاقل
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror

                    <label for="phoneNumber">رقم الهاتف</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}" required>
                    @error('phoneNumber')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الرقم الذي ادخلته موجود مسبقا يرجى التأكد من رقم هاتفك ثم اعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror

                    <label for="location">العنوان</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" required>

                    <label for="specializtion">التخصص</label>
                    <input type="text" id="specializtion" name="specializtion"
                        value="{{ old('specializtion') }}"required>
                    <input type="text" name="role" value="doctor" hidden>

                    <label for="genre">النوع</label>
                    <select name="genre" id="genre" required>
                        <option hidden></option>
                        <option value="ذكر">ذكر</option>
                        <option value="انثى">أنثى</option>
                    </select>
                    <div class="double-row work-times">
                        @if (!empty($message))
                            <div class="error-message" x-data="{ open: true }" x-show="open">
                                <h4 style="margin: 0;">رسالة خطأ</h4>
                                <p>
                                    المواعيد التي قمت بادخالها خاطئة يرجى التأكد واعادةالمحاولة
                                </p>
                                <button class="" @click="open = false">موافق</button>
                            </div>
                        @endif

                        <div>
                            <label for="openningTime">بدء&nbspالدوام</label>
                            <input type="time" id="openningTime" name="openningTime"
                                value="{{ old('openningTime') }}" required>
                        </div>
                        <div>
                            <label for="closingTime">انتهاء&nbspالدوام</label>
                            <input type="time" id="closingTime" name="closingTime"
                                value="{{ old('closingTime') }}" required>
                        </div>

                    </div>
                    <input type="text" name="state" value="processing" hidden>
                    <div class="double-row break-times">
                        <div>
                            <label for="break-beginning-time">بدء&nbspالاستراحة</label>
                            <input type="time" id="break-beginning-time" name="breakbeginningtime"
                                value="{{ old('breakbeginningtime') }}">
                        </div>
                        <div>
                            <label for="break-ending-time">انتهاء&nbspالاستراحة</label>
                            <input type="time" id="break-ending-time" name="breakendingtime"
                                value="{{ old('breakendingtime') }}">
                        </div>
                    </div>
                    <label for="treatmentDuration">مدة&nbspالمعالجة</label>
                    <select name="treatmentDuration" id="treatmentDuration" required>
                        <option hidden></option>
                        <option value="15">15m</option>
                        <option value="30">30m</option>
                        <option value="45">45m</option>
                        <option value="60">1h</option>
                    </select>



                    <label for="medicalNumer">الرقم التسلسي في النقابة</label>
                    <input type="text" id="medicalNumer" name="medicalNumer" value="{{ old('medicalNumer') }}"
                        required>
                    @error('medicalNumer')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الرقم الذي ادخلته موجود مسبقا يرجى التأكد من الرقم الطبي الخاص بك ثم اعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror

                    <label for="certificateImage">صورة شهادة الاختصاص </label>

                    <input type="file" id="certificateImage" name="certificateImage" required>
                    <input type="submit" class="submit button" value="ارسال">
                </form>
            </div>
            <!-- end doctor form -->

            <!-- begin patient form -->
            <div class="patient reg">
                <h2 id="patientTitle" class="hid">مستخدم</h2>
                <form method="POST" action="/signup/patientSignup" class="login hid" id="regPatient">
                    @csrf
                    <label for="full-name">الاسم الكامل</label>
                    <input type="text" id="full-name" name="fullname" value="{{ old('fullname') }}">
                    @error('fullname')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الاسم الذي ادخلته موجود مسبقا يرجى اعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror

                    <label for="email">البريد الالكتروني</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الحساب الذي ادخلته موجود مسبقا يرجى التأكد من حسابك واعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror
                    <label for="phoneNumber">رقم الهاتف</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}">
                    @error('phoneNumber')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الرقم الذي ادخلته موجود مسبقا يرجى التأكد من رقم هاتفك ثم اعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror

                    <label for="password">كلمة السر</label>
                    <input type="password" id="password" name="password">
                    @error('password')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                يجب ان تحتوي كلمة السر على 8 خانات على الاقل واقصى حجم 21 وان تحتوي على حرف واحد على الاقل
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror
                    <label for="location">العنوان</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}">
                    <label for="genre">النوع</label>
                    <select name="genre" id="genre">
                        <option value="none" hidden></option>
                        <option value="ذكر">ذكر</option>
                        <option value="أنثى">أنثى</option>
                    </select>
                    <input type="text" name="role" value="patient" hidden>
                    <input type="submit" class="submit button" value="ارسال">
                </form>
            </div>
            <!-- end patient form -->

            <!-- begin seller form -->
            <div class="seller reg">
                <h2 id="sellerTitle" class="hid">بائع</h2>
                <form method="POST" action="/signup/sellerSignup" class="login hid" id="regSeller">
                    @csrf
                    <label for="full-name">الاسم الكامل</label>
                    <input type="text" id="full-name" name="fullname" value="{{ old('fullname') }}">
                    @error('fullname')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الاسم الذي ادخلته موجود مسبقا يرجى اعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror

                    <label for="email">البريد الالكتروني</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الحساب الذي ادخلته موجود مسبقا يرجى التأكد من حسابك واعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror
                    <label for="phoneNumber">رقم الهاتف</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}">
                    @error('phoneNumber')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                الرقم الذي ادخلته موجود مسبقا يرجى التأكد من رقم هاتفك ثم اعادة المحاولة
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror

                    <label for="password">كلمة السر</label>
                    <input type="password" id="password" name="password">
                    @error('password')
                        <div class="error-message" x-data="{ open: true }" x-show="open">
                            <h4 style="margin: 0;">رسالة خطأ</h4>
                            <p>
                                يجب ان تحتوي كلمة السر على 8 خانات على الاقل واقصى حجم 21 وان تحتوي على حرف واحد على الاقل
                            </p>
                            <button class="" @click="open = false">موافق</button>
                        </div>
                    @enderror
                    <label for="location">العنوان</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}">

                    <input type="text" name="role" value="seller" hidden>
                    <input type="submit" class="submit button" value="ارسال">
                </form>

            </div>
            <!-- begin seller form -->

        </div>
    </div>


    <style>
        :root {
            --color1: #05161A;
            --color2: #072E33;
            --color3: #0C7075;
            --color4: #0F959C;
            --color5: #6DA5C0;
            --color6: #294D61;
            --color7: #EAEBED;
        }

        .error-message {
            position: absolute;
            /* display: none !important; */
            color: black;
            width: 200px;
            height: 200px;
            left: calc(50% - 100px);
            top: calc(50% - 100px);
            background-image: linear-gradient(to right, var(--color5), var(--color7));
            text-align: center;
            padding: 10px;
            border-radius: 5%;
            display: grid;
            grid-template-rows: auto 1fr auto;
            font-size: 20px;
        }

        .error-message button {
            background-color: var(--color6);
            color: var(--color7);
            border-radius: 10%;
            justify-self: center;
        }

        body {
            margin: 8px;
            background-color: var(--color3);
        }

        img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .page {
            height: 95vh;
            padding-bottom: 10px;
            background-color: var(--color3);
            display: grid;
            justify-content: center;
            grid-template-rows: auto auto auto 1fr;
            grid-template-columns: 1fr;
            /* mabye with small screens this will be auto */
            gap: 2%;
        }

        .page *:not(.jobs) {
            margin: 1px auto;
        }


        header {
            display: grid;
            grid-template-columns: 1fr;
            width: 100%;
            background-image: linear-gradient(to right, var(--color1), var(--color5), var(--color1));
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
            color: white;
            display: grid;
            justify-content: center;
            padding: 5px;
            font-size: 30px;
            text-shadow: 5px 5px 3px var(--color3);
        }

        h1 {
            font-size: 35px;
            text-shadow: 5px 5px 3px var(--color5), 10px 10px 3px var(--color3);
        }



        .buttons {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: auto auto;
            justify-content: space-between;
            font-size: 20px;
            text-align: center;
        }



        button,
        .button,
        a {
            text-decoration: none;
            width: 80%;
            background-image: linear-gradient(to right, var(--color3), var(--color2), var(--color3));
            border-radius: 5%;
            transform: skew(-20deg);
            border: none;
            color: var(--color7);
            text-shadow: 5px 5px 3px var(--color5);
            font-size: 20px;
        }

        button:hover,
        input[type="submit"]:hover,
        a:hover {
            cursor: pointer;
            color: var(--color5);
        }


        .reg-span {
            color: var(--color7);
            text-shadow: 5px 5px 3px var(--color5);
            grid-row: 1;
            grid-column: 1 / 4;
            font-size: 23px;
            font-weight: bold;
            display: flex !important;
            justify-content: center;
            overflow: hidden;
        }




        .forms {
            padding: 10px;
            margin: 20px auto;
            width: 50ch;
            border-radius: 3%;
            display: grid;
            box-shadow: 0px 0px 5px 6px var(--color2);
            grid-template-columns: 1fr;
            grid-template-rows: 1fr;
            justify-content: center;
            animation-name: none;
            transform: rotateX(0deg) rotateY(90deg);

            background-image: linear-gradient(to left, var(--color2), var(--color4));

            transform-style: preserve-3d;

            animation-duration: 2s;
            animation-direction: normal;
            animation-fill-mode: forwards;

        }


        .forms>* {
            backface-visibility: hidden;
            width: 99%;
            height: fit-content;
            border-radius: 3%;
        }

        .login {
            width: fit-content;
            height: auto !important;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 5px 5px;
            justify-content: center;
            align-items: center;
            color: var(--color7);
        }


        .submit {
            grid-column: 1/3;
            background-image: linear-gradient(to right, var(--color1), var(--color4));
        }

        h2 {
            color: var(--color7);
            display: flex;
            justify-content: center;
        }


        .patient {
            grid-column: 1/2;
            grid-row: 1/2;
            position: relative;
            /* top: 0px; */
            transform: rotateY(-180deg);
            /* height:inherit !important; */
            /* padding: 2% 0; */
        }

        .doctor {
            grid-column: 1/2;
            grid-row: 1/2;

            position: relative;

        }

        .seller {
            grid-column: 1/2;
            grid-row: 1/2;

            position: relative;

            transform: rotateY(-180deg);
        }











        .double-row {
            grid-column: 1/3;
            display: grid;
            grid-template-columns: 1fr 1fr;

        }

        .double-row>* {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px;
            /* justify-content: center; */
            /* justify-content: flex-end; */
        }

        .double-row label {
            display: grid;
            justify-content: center;

        }



        .genre {
            display: grid;
            justify-content: flex-end;
            grid-template-columns: 1fr 1fr;
            gap: 0 47%;
        }

        .treatmentDuration {
            display: grid;
            justify-content: flex-start;
            grid-template-columns: 1fr 1fr;
            gap: 0 13%;
        }


        input[type]:not(.button):not([type=time]):not(.work) {
            width: 90%;
            border: none;
            border-radius: 0%;

        }



        input[type=time] {
            width: 95%;
            font-size: 14px;
        }

        .hid {
            display: none;
        }


        /* doctor animations */
        @keyframes from-patient-to-doctor {
            from {
                transform: rotateX(0deg) rotateY(-180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 225px;
            }

            to {
                transform: rotateY(0deg);
                background-image: linear-gradient(to right, var(--color2), var(--color4));
                height: 410px;
            }
        }

        @keyframes from-seller-to-doctor {
            from {
                transform: rotateX(0deg) rotateY(-180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 200px;
            }

            to {
                background-image: linear-gradient(to right, var(--color2), var(--color4));

                transform: rotateY(0deg);
                height: 410px;
            }
        }


        /* patient animations */

        @keyframes from-doctor-to-patient {
            from {
                transform: rotateY(0deg);
                background-image: linear-gradient(to right, var(--color2), var(--color4));

                height: 410px;
            }

            to {
                transform: rotateX(0deg) rotateY(-180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 225px;
            }
        }

        @keyframes from-seller-to-patient {
            from {
                transform: rotateX(0deg) rotateY(-180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 200px;
            }

            to {
                transform: rotateX(0deg) rotateY(180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 225px;
            }
        }








        /* seller animations */
        @keyframes from-doctor-to-seller {
            from {
                transform: rotateY(0deg);
                background-image: linear-gradient(to right, var(--color2), var(--color4));
                height: 410px;
            }

            to {

                transform: rotateX(0deg) rotateY(-180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 200px;
            }
        }

        @keyframes from-patient-to-seller {
            from {
                transform: rotateX(0deg) rotateY(-180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 225px;
            }

            to {
                transform: rotateX(0deg) rotateY(180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 200px;
            }
        }

        @keyframes from-initialAnimiation-to-doctor {
            from {
                transform: rotateX(0deg) rotateY(90deg);
                background-image: linear-gradient(to right, var(--color2), var(--color4));
                height: 410px;
            }

            to {
                background-image: linear-gradient(to right, var(--color2), var(--color4));
                transform: rotateY(0deg);
                height: 410px;
            }
        }

        @keyframes from-initialAnimiation-to-patient {
            from {
                transform: rotateX(0deg) rotateY(90deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 225px;
            }

            to {
                transform: rotateX(0deg) rotateY(180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 225px;
            }
        }



        @keyframes from-initialAnimiation-to-seller {
            from {
                transform: rotateX(0deg) rotateY(90deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 200px;
            }

            to {
                transform: rotateX(0deg) rotateY(180deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 200px;
            }
        }


        @keyframes initialAnimiation {
            from {
                transform: rotateX(0deg) rotateY(90deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 260px;
            }

            to {
                transform: rotateX(0deg) rotateY(90deg);
                background-image: linear-gradient(to left, var(--color2), var(--color4));
                height: 260px;
            }
        }


        @media (max-width:350px) {
            body {
                zoom: 60%;
            }
        }



        @media (max-width:500px) {
            body {
                zoom: 80%;
            }
        }















        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */

        /* Document
   ========================================================================== */

        /**
 * 1. Correct the line height in all browsers.
 * 2. Prevent adjustments of font size after orientation changes in iOS.
 */

        html {
            line-height: 1.15;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }

        /* Sections
     ========================================================================== */

        /**
   * Remove the margin in all browsers.
   */

        body {
            margin: 0;
        }

        /**
   * Render the `main` element consistently in IE.
   */

        main {
            display: block;
        }

        /**
   * Correct the font size and margin on `h1` elements within `section` and
   * `article` contexts in Chrome, Firefox, and Safari.
   */

        h1 {
            font-size: 2em;
            margin: 0.67em 0;
        }

        /* Grouping content
     ========================================================================== */

        /**
   * 1. Add the correct box sizing in Firefox.
   * 2. Show the overflow in Edge and IE.
   */

        hr {
            box-sizing: content-box;
            /* 1 */
            height: 0;
            /* 1 */
            overflow: visible;
            /* 2 */
        }

        /**
   * 1. Correct the inheritance and scaling of font size in all browsers.
   * 2. Correct the odd `em` font sizing in all browsers.
   */

        pre {
            font-family: monospace, monospace;
            /* 1 */
            font-size: 1em;
            /* 2 */
        }

        /* Text-level semantics
     ========================================================================== */

        /**
   * Remove the gray background on active links in IE 10.
   */

        a {
            background-color: transparent;
        }

        /**
   * 1. Remove the bottom border in Chrome 57-
   * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
   */

        abbr[title] {
            border-bottom: none;
            /* 1 */
            text-decoration: underline;
            /* 2 */
            text-decoration: underline dotted;
            /* 2 */
        }

        /**
   * Add the correct font weight in Chrome, Edge, and Safari.
   */

        b,
        strong {
            font-weight: bolder;
        }

        /**
   * 1. Correct the inheritance and scaling of font size in all browsers.
   * 2. Correct the odd `em` font sizing in all browsers.
   */

        code,
        kbd,
        samp {
            font-family: monospace, monospace;
            /* 1 */
            font-size: 1em;
            /* 2 */
        }

        /**
   * Add the correct font size in all browsers.
   */

        small {
            font-size: 80%;
        }

        /**
   * Prevent `sub` and `sup` elements from affecting the line height in
   * all browsers.
   */

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }

        sub {
            bottom: -0.25em;
        }

        sup {
            top: -0.5em;
        }

        /* Embedded content
     ========================================================================== */

        /**
   * Remove the border on images inside links in IE 10.
   */

        img {
            border-style: none;
        }

        /* Forms
     ========================================================================== */

        /**
   * 1. Change the font styles in all browsers.
   * 2. Remove the margin in Firefox and Safari.
   */

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            /* 1 */
            font-size: 100%;
            /* 1 */
            line-height: 1.15;
            /* 1 */
            margin: 0;
            /* 2 */
        }

        /**
   * Show the overflow in IE.
   * 1. Show the overflow in Edge.
   */

        button,
        input {
            /* 1 */
            overflow: visible;
        }

        /**
   * Remove the inheritance of text transform in Edge, Firefox, and IE.
   * 1. Remove the inheritance of text transform in Firefox.
   */

        button,
        select {
            /* 1 */
            text-transform: none;
        }

        /**
   * Correct the inability to style clickable types in iOS and Safari.
   */

        button,
        [type="button"],
        [type="reset"],
        [type="submit"] {
            -webkit-appearance: button;
            appearance: button;
        }

        /**
   * Remove the inner border and padding in Firefox.
   */

        button::-moz-focus-inner,
        [type="button"]::-moz-focus-inner,
        [type="reset"]::-moz-focus-inner,
        [type="submit"]::-moz-focus-inner {
            border-style: none;
            padding: 0;
        }

        /**
   * Restore the focus styles unset by the previous rule.
   */

        button:-moz-focusring,
        [type="button"]:-moz-focusring,
        [type="reset"]:-moz-focusring,
        [type="submit"]:-moz-focusring {
            outline: 1px dotted ButtonText;
        }

        /**
   * Correct the padding in Firefox.
   */

        fieldset {
            padding: 0.35em 0.75em 0.625em;
        }

        /**
   * 1. Correct the text wrapping in Edge and IE.
   * 2. Correct the color inheritance from `fieldset` elements in IE.
   * 3. Remove the padding so developers are not caught out when they zero out
   *    `fieldset` elements in all browsers.
   */

        legend {
            box-sizing: border-box;
            /* 1 */
            color: inherit;
            /* 2 */
            display: table;
            /* 1 */
            max-width: 100%;
            /* 1 */
            padding: 0;
            /* 3 */
            white-space: normal;
            /* 1 */
        }

        /**
   * Add the correct vertical alignment in Chrome, Firefox, and Opera.
   */

        progress {
            vertical-align: baseline;
        }

        /**
   * Remove the default vertical scrollbar in IE 10+.
   */

        textarea {
            overflow: auto;
        }

        /**
   * 1. Add the correct box sizing in IE 10.
   * 2. Remove the padding in IE 10.
   */

        [type="checkbox"],
        [type="radio"] {
            box-sizing: border-box;
            /* 1 */
            padding: 0;
            /* 2 */
        }

        /**
   * Correct the cursor style of increment and decrement buttons in Chrome.
   */

        [type="number"]::-webkit-inner-spin-button,
        [type="number"]::-webkit-outer-spin-button {
            height: auto;
        }

        /**
   * 1. Correct the odd appearance in Chrome and Safari.
   * 2. Correct the outline style in Safari.
   */

        [type="search"] {
            -webkit-appearance: textfield;
            /* 1 */
            appearance: textfield;
            outline-offset: -2px;
            /* 2 */
        }

        /**
   * Remove the inner padding in Chrome and Safari on macOS.
   */

        [type="search"]::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        /**
   * 1. Correct the inability to style clickable types in iOS and Safari.
   * 2. Change font properties to `inherit` in Safari.
   */

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            /* 1 */
            font: inherit;
            /* 2 */
        }

        /* Interactive
     ========================================================================== */

        /*
   * Add the correct display in Edge, IE 10+, and Firefox.
   */

        details {
            display: block;
        }

        /*
   * Add the correct display in all browsers.
   */

        summary {
            display: list-item;
        }

        /* Misc
     ========================================================================== */

        /**
   * Add the correct display in IE 10+.
   */

        template {
            display: none;
        }

        /**
   * Add the correct display in IE 10.
   */

        [hidden] {
            display: none;
        }
    </style>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        let forms = document.getElementById("forms");

        function TransformToDoctor() {
            let doc = document.getElementById("regDoctor");
            let docTitle = document.getElementById("doctorTitle");

            let sel = document.getElementById("regSeller");
            let selTitle = document.getElementById("sellerTitle");

            let pat = document.getElementById("regPatient");
            let patTitle = document.getElementById("patientTitle");

            const docList = doc.classList;
            const doctorList = docTitle.classList;

            const selList = sel.classList;
            const selTitleList = selTitle.classList;

            const patList = pat.classList;
            const patTitleList = patTitle.classList;

            if (!forms.style.animationName) {
                forms.style.animationName = "from-initialAnimiation-to-doctor";
                selList.add("hid");
                selTitleList.add("hid");

                patList.add("hid");
                patTitleList.add("hid");

                doctorList.remove("hid");
                docList.remove("hid");
            } else {
                let splitForm = forms.style.animationName.split("-");
                var newAnimation = "from-" + splitForm[3] + "-to-doctor";
                if (splitForm[3] != "doctor") forms.style.animationName = newAnimation;
                setTimeout(function() {
                    selList.add("hid");
                    selTitleList.add("hid");

                    patList.add("hid");
                    patTitleList.add("hid");

                    doctorList.remove("hid");
                    docList.remove("hid");
                }, 600);
            }
        }

        function TransformToPatient() {



            let sel = document.getElementById("regSeller");
            let selTitle = document.getElementById("sellerTitle");


            let pat = document.getElementById("regPatient");
            let patTitle = document.getElementById("patientTitle");


            let doc = document.getElementById("regDoctor");
            let docTitle = document.getElementById("doctorTitle");



            const selList = sel.classList;
            const selTitleList = selTitle.classList;

            const patList = pat.classList;
            const patTitleList = patTitle.classList;

            const docList = doc.classList;
            const docTitleList = docTitle.classList;

            if (!forms.style.animationName) {

                forms.style.animationName = "from-initialAnimiation-to-patient";
                selList.add("hid");
                selTitleList.add("hid");

                patList.remove("hid");
                patTitleList.remove("hid");

                docList.add("hid");
                docTitleList.add("hid");

            } else {
                let splitForm = forms.style.animationName.split("-");
                var newAnimation = "from-" + splitForm[3] + "-to-patient";
                if (splitForm[3] != "patient") forms.style.animationName = newAnimation;


                setTimeout(function() {
                    selList.add("hid");
                    selTitleList.add("hid");

                    patList.remove("hid");
                    patTitleList.remove("hid");

                    docList.add("hid");
                    docTitleList.add("hid");

                }, 600);
            }

        }

        function TransformToSeller() {

            let doc = document.getElementById("regDoctor");
            let docTitle = document.getElementById("doctorTitle");

            let sel = document.getElementById("regSeller");
            let selTitle = document.getElementById("sellerTitle");

            let pat = document.getElementById("regPatient");
            let patTitle = document.getElementById("patientTitle");

            const docList = doc.classList;
            const doctorList = docTitle.classList;

            const selList = sel.classList;
            const selTitleList = selTitle.classList;

            const patList = pat.classList;
            const patTitleList = patTitle.classList;

            if (!forms.style.animationName) {
                forms.style.animationName = "from-initialAnimiation-to-seller";
                selList.remove("hid");
                selTitleList.remove("hid");

                patList.add("hid");
                patTitleList.add("hid");

                doctorList.add("hid");
                docList.add("hid");
            } else {
                let splitForm = forms.style.animationName.split("-");
                var newAnimation = "from-" + splitForm[3] + "-to-seller";
                if (splitForm[3] != "seller") forms.style.animationName = newAnimation;

                setTimeout(function() {
                    selList.remove("hid");
                    selTitleList.remove("hid");

                    patList.add("hid");
                    patTitleList.add("hid");

                    doctorList.add("hid");
                    docList.add("hid");
                }, 600);
            }
        }



        let doctorbtn = document.getElementById("doctor");
        doctorbtn.addEventListener("click", TransformToDoctor);

        let patientbtn = document.getElementById("patient");
        patientbtn.addEventListener("click", TransformToPatient);

        let sellerbtn = document.getElementById("seller");
        sellerbtn.addEventListener("click", TransformToSeller);
    </script>




    </div>
</body>

</html>
