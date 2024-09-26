<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/loginCss.css">
    <link rel="stylesheet" href="css/normalize.css">
    <title>تسجيل الدخول</title>
</head>

<body>
    <div class="page">
        <header>
            <div>
                <h1 style="display: inline;">نبض</h1>
                <img src="{{ asset('storage/logo/logo.jpg') }}" alt="">
            </div>
        </header>
        <div>
            <span class="reg-span">ادخل بريدك الالكتروني وكلمة السر فنحن بانتظارك </span>
        </div>

        <div class="form">
            <h2>تسجيل الدخول</h2>
            <form method="POST" action="/login" class="login" id="lofinForm">
                @csrf
                <label for="email">البريد الالكتروني</label>
                <input type="email" id="email" name="email" />
                <label for="password">كلمة السر</label>
                <input type="password" id="password" name="password" />
                <input type="submit" class="submit button" value="ارسال" />
            </form>
        </div>
        <a href="/signup" class="loginbtn">تسجيل حساب جديد</a>
        @if (!empty($message))
            <div class="error-message" x-data="{ open: true }" x-show="open">
                <h4 style="margin: 0;">رسالة خطأ</h4>
                <p>
                    {{ $message }}
                </p>
                <button class="" @click="open = false">موافق</button>
            </div>
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
            width: 100%;
            margin: 8px;
            background-color: var(--color3);
        }

        img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .page {
            background-color: var(--color3);
            display: grid;
            justify-content: center;
            align-items: flex-start;

            grid-template-rows: auto auto 1fr 1fr;
            grid-template-columns: 1fr;
            gap: 10%;
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
            gap: 0px;
            padding: 20px;
            font-size: 35px;
            text-shadow: 5px 5px 3px var(--color3);
        }


        h1 {
            text-shadow: 5px 5px 3px var(--color5), 10px 10px 3px var(--color3);
        }


        .page * {
            margin: 1px auto;
        }

        h2 {
            color: var(--color7);
            display: flex;
            justify-content: center;
        }

        .form {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr;
        }

        .form:first-child {
            grid-column: 1/3;
        }

        .form {
            padding: 10px;
            margin: 20px auto;
            width: 50ch;
            height: fit-content;
            border-radius: 3%;
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: auto 1fr;
            gap: 20px 20px;
            box-shadow: 0px 0px 5px 6px var(--color2);
            justify-content: center;
            background-image: linear-gradient(to right, var(--color2), var(--color4));
        }

        .reg-span {
            color: var(--color7);
            text-shadow: 5px 5px 3px var(--color5);
            font-size: 20px;
            font-size: 23px;
            font-weight: bold;
        }

        .login {
            width: fit-content;
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* grid-template-rows: 1fr 1fr; */
            gap: 5px 5px;
            justify-content: center;
            align-items: center;
            color: var(--color7);
        }

        .submit {
            grid-column: 1/3;
        }

        .button {
            width: 80%;
            background-image: linear-gradient(to right, var(--color3), var(--color1), var(--color3));
            border-radius: 5%;
            transform: skew(-20deg);
            border: none;
            color: var(--color7);
            text-shadow: 5px 5px 3px var(--color5);
            font-size: 20px;
        }


        a {
            text-decoration: none;
            width: 80%;
            width: fit-content;
            padding: 2px 100px;

            background-image: linear-gradient(to right, var(--color3), var(--color2), var(--color3));
            border-radius: 5%;
            transform: skew(-20deg);
            border: none;
            color: var(--color7);
            text-shadow: 5px 5px 3px var(--color5);
            font-size: 20px;
        }

        @media (max-width:470px) {
            body {
                zoom: 80%;
            }
        }

        @media (max-width:370px) {
            body {
                zoom: 60%;
            }
        }


        @media (max-width:290px) {
            body {
                zoom: 50%;
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
