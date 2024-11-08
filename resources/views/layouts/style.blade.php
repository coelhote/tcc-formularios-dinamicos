<style>
/*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
html {
    line-height: 1.15;
    -webkit-text-size-adjust: 100%
}

body {
    margin: 0;
    font-family: 'Nunito', sans-serif;
}

a {
    background-color: transparent
}

[hidden] {
    display: none
}

html {
    line-height: 1.5
}

*,
:after,
:before {
    box-sizing: border-box;
    border: 0 solid #e2e8f0
}

a {
    color: inherit;
    text-decoration: inherit
}

svg,
video {
    display: block;
    vertical-align: middle
}

video {
    max-width: 100%;
    height: auto
}

.bg-white {
    --tw-bg-opacity: 1;
    background-color: rgb(255 255 255 / var(--tw-bg-opacity))
}

.bg-red {
    --tw-bg-opacity: 1;
    background-color: rgb(255 0 0 / var(--tw-bg-opacity))
}

.bg-gray-100 {
    --tw-bg-opacity: 1;
    background-color: rgb(243 244 246 / var(--tw-bg-opacity))
}

.border-gray-200 {
    --tw-border-opacity: 1;
    border-color: rgb(229 231 235 / var(--tw-border-opacity))
}

.border-t {
    border-top-width: 1px
}

.flex {
    display: flex
}

.grid {
    display: grid
}

.hidden {
    display: none !important;
}

.items-center {
    align-items: center
}

.justify-center {
    justify-content: center
}

.font-semibold {
    font-weight: 600
}

.h-5 {
    height: 1.25rem
}

.h-8 {
    height: 2rem
}

.h-16 {
    height: 4rem
}

.text-sm {
    font-size: .875rem
}

.text-lg {
    font-size: 1.125rem
}

.leading-7 {
    line-height: 1.75rem
}

.mx-auto {
    margin-left: auto;
    margin-right: auto
}

.ml-1 {
    margin-left: .25rem
}

.mt-2 {
    margin-top: .5rem
}

.mr-2 {
    margin-right: .5rem
}

.ml-2 {
    margin-left: .5rem
}

.mt-4 {
    margin-top: 1rem
}

.ml-4 {
    margin-left: 1rem
}

.mt-8 {
    margin-top: 2rem
}

.ml-12 {
    margin-left: 3rem
}

.-mt-px {
    margin-top: -1px
}

.max-w-6xl {
    max-width: 72rem
}

.min-h-screen {
    min-height: 100vh
}

.overflow-hidden {
    overflow: hidden
}

.p-6 {
    padding: 1.5rem
}

.py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem
}

.px-6 {
    padding-left: 1.5rem;
    padding-right: 1.5rem
}

.pt-8 {
    padding-top: 2rem
}

.fixed {
    position: fixed
}

.relative {
    position: relative
}

.top-0 {
    top: 0
}

.right-0 {
    right: 0
}

.shadow {
    --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);
    --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}

.text-center {
    text-align: center
}

.text-gray-200 {
    --tw-text-opacity: 1;
    color: rgb(229 231 235 / var(--tw-text-opacity))
}

.text-gray-300 {
    --tw-text-opacity: 1;
    color: rgb(209 213 219 / var(--tw-text-opacity))
}

.text-gray-400 {
    --tw-text-opacity: 1;
    color: rgb(156 163 175 / var(--tw-text-opacity))
}

.text-gray-500 {
    --tw-text-opacity: 1;
    color: rgb(107 114 128 / var(--tw-text-opacity))
}

.text-gray-600 {
    --tw-text-opacity: 1;
    color: rgb(75 85 99 / var(--tw-text-opacity))
}

.text-gray-700 {
    --tw-text-opacity: 1;
    color: rgb(55 65 81 / var(--tw-text-opacity))
}

.text-gray-900 {
    --tw-text-opacity: 1;
    color: rgb(17 24 39 / var(--tw-text-opacity))
}

.underline {
    text-decoration: underline
}

.antialiased {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale
}

.w-5 {
    width: 1.25rem
}

.w-8 {
    width: 2rem
}

.w-auto {
    width: auto
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr))
}

@media (min-width:640px) {
    .sm\:rounded-lg {
        border-radius: .5rem
    }

    .sm\:block {
        display: block
    }

    .sm\:items-center {
        align-items: center
    }

    .sm\:justify-start {
        justify-content: flex-start
    }

    .sm\:justify-between {
        justify-content: space-between
    }

    .sm\:h-20 {
        height: 5rem
    }

    .sm\:ml-0 {
        margin-left: 0
    }

    .sm\:px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem
    }

    .sm\:pt-0 {
        padding-top: 0
    }

    .sm\:text-left {
        text-align: left
    }

    .sm\:text-right {
        text-align: right
    }
}

@media (min-width:768px) {
    .md\:border-t-0 {
        border-top-width: 0
    }

    .md\:border-l {
        border-left-width: 1px
    }

    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr))
    }
}

@media (min-width:1024px) {
    .lg\:px-8 {
        padding-left: 2rem;
        padding-right: 2rem
    }
}

body {
    font-family: 'Nunito', sans-serif;
}

.form-control {
    display: flex !important;
    /* border: none !important; */
    padding: 16px !important;
}

.space-between {
    justify-content: space-between;
}

.flex-end {
    justify-content: flex-end;
}

.select-type-answer {
    display: flex;
    align-items: center;
}

.select-type-answer [type="radio"]:not(#radio) {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.select-type-answer [type=radio]+div {
    cursor: pointer;
}

.select-type-answer [type=radio]:checked+div {
    outline: 2px solid #909392;
}

/* .square {
    width: 120px;
    height: 120px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
} */

.square {
    width: 100%;
    height: 120px;
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 5px;
    cursor: pointer;
}

.square:hover {
    background-color: #e2e6ea;
}

.big-square {
    width: 200px;
    height: 200px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #ced4da;
    border-radius: 10px;
    margin-bottom: 15px;
    margin-right: 5px;
    text-decoration: none;
    cursor: pointer;
}

.big-square span {
    text-decoration: none;
}

.big-square:nth-child(3n) {
    margin-right: 0;
}

.error {
    color: red !important;
    border-color: red !important;
}

.success {
    color: green !important;
}

.alert,
.warning {
    color: red !important;
}

.navbar {
    background-color: #007bff;
}

.nav-link {
    transition: color 0.3s;
    color: white !important;
}

.nav-link:hover {
    color: #66b3ff;
}

footer {
    background-color: #f8f9fa;
    color: #333;
}

header {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 1.2rem;
    color: #007bff;
}

.btn {
    border-radius: 20px;
    padding: 5px 20px;
}

.table {
    border-radius: 10px;
}

.table th, .table td {
    vertical-align: middle;
}

.question-container {
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    padding: 15px;
    background-color: #f9f9f9;
    margin-bottom: 15px;
}

.step-container,
.condition-container,
.question-block {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 15px;
    background-color: #f9f9f9;
    margin-bottom: 15px;
}

.text-blue {
    text-decoration: underline;
    color: blue;
}

.text-red {
    text-decoration: underline;
    color: red;
}

#loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.spinner {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>