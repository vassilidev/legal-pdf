<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        setting([
            'contract.css'                => " #render {
            -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently supported by Chrome and Opera */
            background: url(https://i.ibb.co/09Jvc9s/Mask-group.png);
            background-repeat: round;
        }

        .blur {
            color: transparent;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }",
            'builder.final_component'     => '{"key":"finalPage","type":"panel","input":false,"label":"","title":"","tableView":false,"components":[{"key":"surveyUserEmail","type":"email","input":true,"label":"{{ contract.email_option_text }}","tableView":true,"applyMaskOn":"change","validate":{"required":true}}]}',
            'builder.signature_component' => '{"key":"signatureOption","type":"panel","input":false,"label":"","title":"Options","tableView":false,"components":[{"key":"content","html":"<p><strong> {{ contract.signature_option_text }} <\/strong><\/p>","type":"content","input":false,"label":"Content","tableView":false,"refreshOnChange":false},{"key":"signatureOption","type":"checkbox","input":true,"label":"' . __('contract.signature_option_checkbox') . '","tableView":false,"defaultValue":false}]}'
        ]);
    }
}
