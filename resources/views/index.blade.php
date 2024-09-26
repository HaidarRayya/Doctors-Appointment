<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="css/mainPage.css">
    <link rel="stylesheet" href="css/normalize.css">
    <title>الصفحة الرئيسية</title>
</head>

<body>
    <div class="page">
        <div class="title">
            <div>
                <h1 style="display: inline; margin: 0px;">نبض</h1>
                <img src="{{ asset('storage/logo/logo.jpg') }}" alt="">
            </div>
        </div>
        <header>
            @php
                $user = Auth::user();
            @endphp

            <div style="opacity: 1;">
                @if (Auth::user())
                    <img src="{{ $user->ProfilePhoto ? asset('storage/' . $user->ProfilePhoto) : asset('storage/logo/noImg.png') }}"
                        alt="">
                @else
                    <img src="{{ asset('storage/logo/noImg.png') }}" alt="">
                @endif
                <span>
                    @if (Auth::user())
                        {{ Auth::user()->fullname }}
                    @endif
                </span>
                <div>
                    @if (Auth::user())
                        @if (Auth::user()->role === 'doctor')
                            <span>نقاطك:</span>
                            <span>
                                {{ Auth::user()->points }}
                            </span>
                        @endif
                    @endif
                </div>
            </div>



            <div>
                @auth
                    <a href="/logout">تسجيل خروج</a>
                @endauth

                @guest
                    <a href="/login">تسجيل دخول</a>
                    <a href="/signup">تسجيل </a>
                @endguest
            </div>

        </header>

        <nav>
            <a href="/" class="this-page"> الصفحة الرئيسية </a>
            @if (Auth::user())
                @if (Auth::user()->role === 'doctor')
                    <a href="/calender/{{ $user->id }}"> مواعيدي </a>
                @elseif(Auth::user()->role === 'patient')
                    <a href="/dailyDatesPatient/{{ $user->id }}"> مواعيدي </a>
                @endif
            @else
                <a href="/mm"> مواعيدي </a>
            @endif


            @if (Auth::user())
                @if (Auth::user()->role === 'doctor')
                    <a href="/updateAccountDoctor/{{ $user->id }}"> تعديل الملف الشخصي </a>
                @elseif(Auth::user()->role === 'patient')
                    <a href="/updateAccountPatient/{{ $user->id }}"> تعديل الملف الشخصي </a>
                @elseif(Auth::user()->role === 'seller')
                    <a href="/updateAccountSeller/{{ $user->id }}"> تعديل الملف الشخصي </a>
                @endif
            @else
                <a href="/update"> تعديل الملف الشخصي </a>
            @endif
            <a href="/contactUs"> تواصل معنا </a>
        </nav>

        <aside id="sidebar">
            <h4>مواعيد اليوم</h4>
            <div class="aside-head">
                <span>الساعة</span>
                <span>موعد مع</span>
            </div>

            <div class="aside-section">
                @if (Auth::user())
                    @if (Auth::user()->role === 'doctor')
                        @foreach ($appointmentsDoctorWithName as $i)
                            <div>
                                <span>{{ $i[0] . ' ' . $i[2] }}</span>
                                <span>{{ $i[1] }}</span>
                            </div>
                        @endforeach
                    @elseif(Auth::user()->role === 'patient')
                        @foreach ($appointmentsPatientWithName as $i)
                            <div>
                                <span>{{ $i[0] . ' ' . $i[2] }}</span>
                                <span>{{ $i[1] }}</span>
                            </div>
                        @endforeach
                    @endif
                @else
                @endif


        </aside>
        <div class="search">
            <form action="/">
                <button type="submit">بحث</button>
                <input type="search" type="text" name="search" id="search">
            </form>
        </div>

        <section id="section">
            <div class="section-title">أطباء قد ترغب في زيارتهم</div>

            @foreach ($doctors as $doctor)
                <div class="div-one">
                    <img src="{{ $doctor->ProfilePhoto ? asset('storage/' . $doctor->ProfilePhoto) : asset('storage/logo/noImg.png') }}"
                        alt="">
                    <div class="name" id="name">{{ $doctor->fullname }}</div>
                    <div class="specialisation">التخصص:</div>
                    <div class="specialisation" id="specialisation" style="display: inline;">
                        {{ $doctor->specializtion }}</div>
                    <div class="location">العنوان:</div>
                    <div class="location" id="location">{{ $doctor->location }}</div>
                    <div class="phoneNumber">رقم الهاتف:</div>
                    <div class="phoneNumber" id="phoneNumber" style="display: inline;">{{ $doctor->phoneNumber }}</div>
                    @if (Auth::user())
                        @if (Auth::user()->role === 'doctor')
                            @if (Auth::user()->id === $doctor->id)
                                <a href="/calender/{{ $doctor->id }}">حجز</a>
                            @else
                                <a href="/">حجز</a>
                            @endif
                        @else
                            <a href="/calender/{{ $doctor->id }}">حجز</a>
                        @endif
                    @else
                        <a href="/calender/{{ $doctor->id }}">حجز</a>
                    @endif

                </div>
            @endforeach

        </section>

        @if ($doctors->total() > 4)
            <footer>
                <div class="buttons">
                    @php
                        $i = 0;
                    @endphp
                    @for ($x = 1; $x <= $doctors->total(); $x += 4)
                        @php
                            $i++;
                        @endphp
                        <button> <a href="/?page={{ $i }}"> {{ $i }} </a></button>
                    @endfor
                </div>
            </footer>
        @endif
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
            background-color: var(--color3);
            margin: 8px;
            zoom: 90%;
        }

        img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        a {
            color: var(--color7);
            text-decoration: none;
            font-size: 20px;
        }

        a:hover:not(.this-page),
        button:hover {
            color: var(--color5);
            cursor: pointer;
        }






        .page {

            height: fit-content;
            display: grid;
            grid-template-columns: 2fr 5% 1fr;
            grid-template-rows: 85px 45px 50px 25px 1fr 30px;
            gap: 10px;
        }

        .title {
            grid-row: 1/2;
            grid-column: 1/4;
            display: grid;
            grid-template-columns: auto;
            justify-items: center;

            background-image: linear-gradient(to right, var(--color1), var(--color5), var(--color1));
            color: white;
            font-size: 30px;
            text-shadow: 5px 5px 3px var(--color5), 10px 10px 3px var(--color3);

            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        .title div {
            display: grid;
            grid-template-columns: auto auto;
            justify-items: center;
            color: var(--color7);
            align-items: center;
            gap: 10px;


        }


        header {

            color: var(--color7) !important;
            padding: 0px 10px;
            grid-column: 1/4;

            display: grid;
            grid-template-columns: auto 1fr auto;
            justify-items: flex-start;
            align-items: flex-start;
        }

        header div {
            display: grid;
            align-self: center;
            align-items: center;
            justify-items: center;
        }

        header div:first-child {
            grid-column: 1/2;
            grid-template-columns: 1fr 1fr auto auto;
            gap: 0px 15px;
            font-weight: bold;
            text-shadow: 5px 5px 3px var(--color5);
            font-size: 20px;
        }

        header div:last-child {
            grid-column: 3/4;
            grid-row: 1/2;
            grid-template-columns: auto 1fr auto;
            gap: 0px 10px;
            text-shadow: 5px 5px 3px var(--color5);
            font-size: 20px;
        }







        nav {
            padding: 0px 10px;
            grid-column: 1/4;

            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-template-rows: auto;
            justify-content: flex-start;
            gap: 1%;
            align-items: center;
            border-top: 2px solid var(--color6);

        }

        nav * {
            height: 100%;
            background-image: linear-gradient(to right, var(--color3), var(--color2), var(--color3));
            border-radius: 5%;
            transform: skew(-20deg);
            border: none;
            color: var(--color7);
            text-shadow: 5px 5px 3px var(--color5);
            font-size: 16px;
            display: grid;
            justify-content: center;
            align-items: center;
        }

        .this-page {
            background-image: linear-gradient(to right, var(--color3), var(--color7), var(--color3));
            color: var(--color1);
            text-shadow: 5px 5px 3px var(--color5);
        }






        aside {

            grid-column: 3/4;
            grid-row: 5/7;
            padding: 10px;
            margin-top: 15px !important;
            margin-left: 20px;
            height: fit-content;
            font-size: 20px;
            margin-top: 10px;
            border-right: 1px solid var(--color1);
            border-top: 1px solid var(--color1);
            border-bottom: 1px solid var(--color1);
            border-radius: 3px;
            box-shadow: 0px 0px 5px 6px var(--color2);
            background-image: linear-gradient(to left, var(--color2), var(--color4));

            color: var(--color7);

            display: grid;
            grid-template-columns: 40% 60%;
            grid-template-rows: auto auto 1fr;

            justify-content: center;

        }

        aside h4 {
            grid-column: 1/3;
            text-align: center;
            margin: 5%;
            color: var(--color7);
        }

        .aside-head {
            grid-column: 1/3;
            text-align: center;
            display: grid;
            grid-template-columns: 40% 60%;
            margin-bottom: 3%;
            border-bottom: 1px dashed var(--color1);
        }

        .aside-section {
            grid-column: 1/3;
            text-align: center;
        }

        .aside-section div {
            display: grid;
            grid-template-columns: 40% 60%;
            gap: 100px 0px;
            font-size: 20px;
        }




        .search {
            margin-right: 10px;
            color: var(--color7);
            grid-row: 4/5;
            grid-column: 1/4;

        }

        .search input[type="search"] {
            background-image: linear-gradient(to right, var(--color1), var(--color6));

            border: none;
            color: var(--color7);
        }



        .search input[type="submit"] {
            background-image: linear-gradient(to right, var(--color1), var(--color6));
            color: var(--color7);
            border-radius: 30%;
        }





        section {
            font-size: 18px;
            margin: 10px;
            grid-column: 1/2;
            grid-row: 5/6;

            display: grid;
            grid-template-columns: 50% 50%;
            /* background-image: linear-gradient(to left,var(--color6) ,var(--color2)); */

            border-radius: 5px;
            gap: 10px;
        }

        section div:first-child {
            grid-column: 1/3;
            color: var(--color7);
            background-image: linear-gradient(to left, var(--color6), var(--color2));
            height: fit-content;
            border-radius: 5px;
            text-align: center;
            align-self: flex-end;
            font-size: 25px;
        }

        section>div:not(div:first-child) {
            color: var(--color7);
            display: grid;
            grid-template-columns: auto auto;
            border-radius: 5px;
            border: 2px #05161A solid;
            box-shadow: 0px 0px 36px 3px var(--color4);
            background-image: linear-gradient(to left, var(--color6), var(--color2));
            justify-content: center;
            align-items: center;
            gap: 0px 5px;
            text-align: center;

        }



        section div a {
            grid-column: 1/3;
            width: fit-content;
            justify-self: center;
            color: var(--color7);
            font-size: 20px;
            border-radius: 5%;
            background-image: linear-gradient(to left, var(--color1), var(--color2));
            border: 2px solid var(--color2);

        }

        section div>div:nth-child(2) {
            font-weight: bold;
            font-size: 25px;
        }

        footer {
            grid-column: 1/2;
            grid-row: 6/7;
            display: grid;
            justify-content: center;
        }

        .buttons {
            width: fit-content;
        }

        input[value="بحث"],
        button {
            background-image: linear-gradient(to right, var(--color1), var(--color6));
            color: var(--color7);
            border-radius: 30%;
        }

        footer button {
            width: 40px;
            height: 40px;
        }


        @media (max-width:780px) {
            body {
                zoom: 80%;
            }
        }

        @media (max-width:611px) {
            body {
                zoom: 70%;
            }

            .page {
                grid-template-columns: 4fr 5% 3fr;
            }

            section div>div:nth-child(2) {
                font-size: 22px;
            }

        }

        @media (max-width:450px) {
            body {
                zoom: 50%;
            }

            .page {
                grid-template-rows: 85px 45px 70px auto 25px auto 30px;
                grid-template-columns: 1fr 3fr 1fr;
            }

            nav {
                font-size: 16px;
            }

            aside {
                grid-column: 2/3;
                grid-row: 4/5;
                font-size: 25px;
            }

            .aside-section div {
                margin-bottom: 5px;
            }

            .aside-section div:nth-child(2n) {
                color: var(--color5);
                font-weight: bold;
            }


            .search {
                grid-row: 5/6;
                grid-column: 1/4;
            }

            section {
                grid-row: 6/7;
                grid-column: 1/4;
                grid-template-columns: 1fr 1fr;
            }

            section div>div:nth-child(2) {
                font-size: 20px;
            }


            footer {
                grid-row: 7/8;
                grid-column: 1/4;

            }

        }


        @media (max-width:300px) {
            body {
                zoom: 50%;
            }
        }

        @media (max-width:250px) {
            aside {
                grid-column: 1/4;
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

</body>

</html>
