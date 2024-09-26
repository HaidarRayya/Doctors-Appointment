<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showDoctorDetails.css">
    <link rel="stylesheet" href="css/normalize.css">
    <title>نبض</title>
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

            <div class="doctorName">
                {{ Auth::user()->fullname }}
            </div>

            <div>
                <a href="/logout">تسجيل خروج</a>
            </div>

        </header>
        <nav>
            <a href="/MainDoctor"> طلبات التسجيل</a>
        </nav>

        <section>
            <div class="detailsContainer">
                <div class="details" id="details">

                    <p>الاسم الكامل:</p>
                    <p>{{ $doctor->fullname }}</p>

                    <p>البريد الالكتروني:</p>
                    <p>{{ $doctor->email }}</p>

                    <p>رقم الهاتف:</p>
                    <p>{{ $doctor->phoneNumber }}</p>

                    <p>العنوان:</p>
                    <p>{{ $doctor->location }}</p>

                    <p>التخصص</p>
                    <p>{{ $doctor->specializtion }}</p>

                    <p>النوع</p>
                    <p>{{ $doctor->genre }}</p>

                    <div class="double-row work-times">
                        <div>
                            <p id="openningTime">بدء&nbspالدوام</p>

                            <p>{{ $doctor->openningTime }}</p>
                        </div>
                        <div>
                            <p id="closingTime">انتهاء&nbspالدوام</p>
                            <p>{{ $doctor->closingTime }}</p>

                        </div>

                    </div>
                    <div class="double-row break-times">

                        <div>
                            <p>بدء&nbspالاستراحة</p>
                            <p id="break-beginning-time">{{ $doctor->breakbeginningtime }}</p>

                        </div>

                        <div>
                            <p>انتهاء&nbspالاستراحة</p>
                            <p id="break-ending-time">{{ $doctor->breakendingtime }}</p>

                        </div>
                    </div>
                    <p>مدة&nbspالمعالجة</p>
                    <p for="treatmentDuration">
                        {{ $doctor->treatmentDuration !== 60 ? $doctor->treatmentDuration . 'm' : '1h' }}</p>




                    <p>الرقم التسلسي في النقابة</p>
                    <p id="medicalNumer">{{ $doctor->medicalNumer }}</p>

                </div>
            </div>

        </section>
        <aside>
            <p id="certificateImage">صورة شهادة الاختصاص </p>
            <img src=" {{ asset('storage/' . $doctor->certificateImage) }}" alt="" class="certificateImage">
        </aside>


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


        body {
            background-color: var(--color3);
            margin: 8px;

            /* zoom: 90%; */
        }

        img:not(.certificateImage) {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .certificateImage {
            width: 50ch;
            height: 50vh;
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
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 85px auto 50px auto 1fr 30px;
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
            height: fit-content;
            display: grid;
            grid-template-columns: auto 1fr auto;
            padding-bottom: 20px;
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


        section {
            grid-column: 2/3;
        }

        .detailsContainer {
            grid-row: 3/4;
            grid-column: 1/3;
            padding: 10px;
            margin: 20px 50px;
            width: 50ch;
            border-radius: 3%;
            display: grid;
            box-shadow: 0px 0px 5px 6px var(--color2);
            grid-template-columns: 1fr;
            grid-template-rows: 1fr;
            justify-content: center;

            background-image: linear-gradient(to left, var(--color2), var(--color4));


        }


        .detailsContainer>* {
            width: 99%;
            height: fit-content;
            border-radius: 3%;
        }

        .details {
            width: fit-content;
            height: auto !important;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 5px 10px;
            justify-content: center;
            align-items: center;
            color: var(--color7);
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

        .details>*:nth-child(2n+1):not(.double-row) {
            color: var(--color5);
            font-weight: bold;
        }

        .double-row div *:nth-child(2n+1) {
            color: var(--color5);
            font-weight: bold;
        }

        aside {
            grid-column: 1/4;
            grid-row: 4/5;
            padding: 10px;
            justify-self: center;
            margin: 20px 50px;
            color: var(--color7);
        }

        @media (max-width:600px) {
            body {
                zoom: 70%;
            }

        }

        @media (max-width:500px) {
            body {
                zoom: 60%;
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
</body>

</html>
