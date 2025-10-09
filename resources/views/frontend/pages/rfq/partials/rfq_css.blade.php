<style>
    
    .progress-bar-steps {
        display: flex;
        margin-bottom: 30px;
        border-bottom: 1px solid #eee;
    }

    .step {
        flex: 1;
        text-align: center;
        display: flex;
        align-items: center;
        padding: 10px 10px;
        border-radius: 0px;
        background-color: #fff;
        transition: background-color 0.3s;
    }

    /* Hide checkmark icons by default */
    .step .fa-check {
        display: none;
    }

    /* Show checkmark icon only on completed steps */
    .step.completed .fa-check {
        display: inline-block;
    }

    /* Style the icon inside the step circle */
    .step .circle i {
        font-size: 16px;
        color: #001430;
        transition: color 0.3s, background-color 0.3s;
    }

    /* Step label default style */
    .step .step-label {
        font-weight: 600;
        font-size: 16px;
        color: #333;
        transition: color 0.3s, background-color 0.3s;
    }

    /* Completed step style */
    .step.completed {
        background-color: #eee;
        color: black;
    }

    .step.completed .step-label,
    .step.completed .circle i {
        background-color: #eee !important;
        color: black !important;
    }

    /* ✅ Active/current step style - red background */
    .step.active {
        background-color: #001430;
        color: white;
    }

    .step.active .step-label,
    .step.active .circle i {
        text-align: center;
        color: #001430 !important;
        background-color: transparent !important;
    }

    .step.completed .circle i,
    .step.completed .step-label {
        color: white;
        font-weight: bold;
    }

    .step-content {
        display: none;
    }

    .step-content.active {
        display: block;
    }

    .icon-info {
        border: 1px solid #eee;
        width: 30px;
        text-align: center;
        height: 30px;
        line-height: 30px;
        cursor: pointer;
    }

    /* for inputs design */

    .form-select {
        color: #212529;
        background-color: #f1f0f0cf;
        border-radius: 0px;
        padding: 13px 10px !important;
        box-shadow: none !important;
        z-index: 10;
        transition-duration: 0.4s;
        -moz-transition-duration: 0.4s;
        -webkit-transition-duration: 0.4s;
        -o-transition-duration: 0.4s;
        border: 1px solid #f1f0f01f;
        font-size: 14px;
    }

    .form-select:focus {
        color: #212529;
        background-color: #f1f0f0cf;
        border-radius: 0px;
        padding: 13px;
        border: 1px solid #f1f0f01f;
        font-size: 14px !important;
        border: 1px solid #f1f0f0cf;
    }

    .form-control:disabled {
        background-color: #f1f0f0cf;
        border-radius: 0px;
        padding: 13px;
    }

    .form-control {
        color: #212529;
        background-color: #f1f0f0cf;
        border-radius: 0px;
        padding: 13px;
        box-shadow: none !important;
        z-index: 0;
        transition-duration: 0.4s;
        -moz-transition-duration: 0.4s;
        -webkit-transition-duration: 0.4s;
        -o-transition-duration: 0.4s;
        font-size: 14px !important;
        font-weight: 500 !important;
        border: 1px solid #f1f0f0cf;
    }

    .is-invalid {
        font-size: 14px !important;
        font-weight: 600;

    }

    .form-control.is-valid:focus,
    .was-validated .form-control:valid:focus {
        border-color: #f1f0f01f;
    }

    .form-control:focus {
        color: #212529;
        background-color: #f1f0f01f;
        border: 1px solid #f1f0f01f;
        border-radius: 0px;
        padding: 13px;
        box-shadow: none !important;
        z-index: 10;
        font-size: 14px !important;
        font-weight: 500 !important;
        transition-duration: 0.4s;
        -moz-transition-duration: 0.4s;
        -webkit-transition-duration: 0.4s;
        -o-transition-duration: 0.4s;
    }


    .form-control::placeholder {
        color: #888888b2;
        opacity: 3;
        font-size: 14px !important;
    }

    .custom-form-check:checked {
        background-color: #001430 !important;
        border-color: #001430 !important;
    }

    .custom-form-check:focus {
        border-color: #001430;
        outline: 0;
        box-shadow: 0 0 0 0.25rem #00143023;
    }

    .check-label {
        font-size: 14px;
        color: #001430;
        font-weight: 600;
    }

    .form-control.is-valid,
    .was-validated .form-control:valid {
        background-image: none !important;
        border: 0px solid #f1f1f1;
    }

    .form-select.is-valid,
    .was-validated .form-select:valid {
        background-image: none !important;
        border: 0px solid #f1f1f1;
    }
    .sl-input.is-valid,
    .was-validated .sl-input:valid {
        border-color: #198754;
        padding-right: 0.75rem;
        /* Or whatever fits your layout */
        background: none !important;
        background-image: none !important;
        background: #f7f7f717 !important;
    }

    /* Hide spinners for number input on Chrome, Safari, Edge */
    input.no-spinners::-webkit-outer-spin-button,
    input.no-spinners::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide spinners for Firefox */
    input.no-spinners[type=number] {
        -moz-appearance: textfield;
    }



    /* Form Inputs For RFQ Design End */
    .rfq-add-btns {
        color: #001430;
        background-color: transparent;
        border: 0;
        padding: 10px;
        border-radius: 0px;
        width: 150px;
        border: 1px solid #001430;
    }

    .rfq-add-btns:hover {
        color: #fff;
        background-color: #001430;
        border-radius: 0px;
        transition: 0.5s all;
    }

    .trash-btn {
        background-color: transparent;
        color: #001430;
        border: 0;
        border-radius: 0px;
        font-size: 20px;
    }

    .trash-btn:hover {
        background-color: red;
        color: white;
        border: 0;
        border-radius: 0px;
        font-size: 20px;
    }

    .next-btn {
        padding: 10px 20px;
        border-radius: 0px;
        width: 150px;
        background-color: #001430;
        border: 1px solid #001430;
    }

    .next-btn:hover {
        padding: 10px 20px;
        width: 150px;
        border-radius: 0px;
        background-color: #001430;
        border: 1px solid #001430;
    }

    .prev-btn {
        padding: 10px 20px;
        border-radius: 0px;
        width: 150px;
        background-color: black;
        border: 1px solid black;
    }

    .prev-btn:hover {
        padding: 10px 20px;
        width: 150px;
        border-radius: 0px;
        background-color: black;
        border: 1px solid black;
    }

    .btn.disabled,
    .btn:disabled,
    fieldset:disabled .btn {
        background-color: #0014306c;
        border: 1px solid #0014306c;
    }



    /* Shine animation keyframes */
    @keyframes shine {
        0% {
            left: -100%;
        }

        40% {
            left: 100%;
        }

        100% {
            left: 100%;
        }
    }

    .qty-btn {
        font-size: 14px;
        padding: 0px;
        width: 30px !important;
        height: 24.5px !important;
    }

    .increment-quantity {
        border: 2px solid #eee;
    }

    .decrement-quantity {

        border: 2px solid #eee;
    }

    .current-step-red {
        background-color: #f1f0f0cf !important;
        /* Bootstrap red */
        color: #001430 !important;
        display: flex;
        justify-content: center;
        box-shadow: rgba(14, 63, 126, 0.04) 0px 0px 0px 1px, rgba(42, 51, 69, 0.04) 0px 1px 1px -0.5px, rgba(42, 51, 70, 0.04) 0px 3px 3px -1.5px, rgba(42, 51, 70, 0.04) 0px 6px 6px -3px, rgba(14, 63, 126, 0.04) 0px 12px 12px -6px, rgba(14, 63, 126, 0.04) 0px 24px 24px -12px;
    }

    .current-step-red .step-label {
        background-color: transparent !important;
        /* Bootstrap red */
        color: #001430 !important;
    }

    .is-invalid {
        border: 0;
    }

    

    .qty-btn:hover i,
    .qty-btn:hover .btn-icons {
        color: white !important;
    }

    @media only screen and (max-width: 600px) {
        .rfq-title {
            font-size: 20px;
        }

        .case-title {
            font-size: 14px;
        }

        .step .step-label {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            transition: color 0.3s;
        }
    }

    .cst-btn {
        background-color: #f9f9f9cf;
        color: #001430 !important;
        padding: 0px !important;
        width: 65px;
        font-size: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-text-btn {
        color: #001430;
        text-decoration: underline;
        font-weight: 400;
    }
</style>