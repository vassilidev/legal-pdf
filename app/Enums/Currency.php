<?php

namespace App\Enums;
enum Currency: string
{
    // Major currencies
    case EUR = 'eur';
    case USD = 'usd';
    case GBP = 'gbp';
    case JPY = 'jpy';
    case AUD = 'aud';
    case CAD = 'cad';
    case CHF = 'chf';
    case CNY = 'cny';
    case SEK = 'sek';
    case NZD = 'nzd';
    case KRW = 'krw';
    case SGD = 'sgd';
    case NOK = 'nok';
    case MXN = 'mxn';
    case HKD = 'hkd';
    case TRY = 'try';
    case RUB = 'rub';
    case INR = 'inr';
    case BRL = 'brl';
    case ZAR = 'zar';

    // African currencies
    case EGP = 'egp'; // Egyptian Pound
    case NGN = 'ngn'; // Nigerian Naira
    case ZMW = 'zmw'; // Zambian Kwacha
    case KES = 'kes'; // Kenyan Shilling
    case GHS = 'ghs'; // Ghanaian Cedi
    case DZD = 'dzd'; // Algerian Dinar
    case MAD = 'mad'; // Moroccan Dirham
    case ETB = 'etb'; // Ethiopian Birr
    case XAF = 'xaf'; // Central African CFA Franc
    case XOF = 'xof'; // West African CFA Franc
    case XCD = 'xcd'; // East Caribbean Dollar

    // Middle Eastern currencies
    case AED = 'aed'; // United Arab Emirates Dirham
    case SAR = 'sar'; // Saudi Riyal
    case QAR = 'qar'; // Qatari Riyal
    case KWD = 'kwd'; // Kuwaiti Dinar
    case OMR = 'omr'; // Omani Rial
    case BHD = 'bhd'; // Bahraini Dinar
    case JOD = 'jod'; // Jordanian Dinar
    case LBP = 'lbp'; // Lebanese Pound
    case IQD = 'iqd'; // Iraqi Dinar
    case IRR = 'irr'; // Iranian Rial
    case SYP = 'syp'; // Syrian Pound
    case YER = 'yer'; // Yemeni Rial
    case AFN = 'afn'; // Afghan Afghani

    public function getSymbol(): string
    {
        return match ($this) {
            // Major currencies
            self::USD, self::AUD, self::CAD, self::NZD, self::SGD, self::HKD, self::MXN, self::XCD => '$',
            self::EUR => '€',
            self::GBP, self::EGP => '£',
            self::JPY => '¥',
            self::CHF, self::CNY, self::KRW, self::NOK, self::TRY, self::INR => '₹',
            self::SEK, self::BRL => 'R$',
            self::RUB => '₽',
            self::ZAR => 'R',

            // African currencies
            self::NGN => '₦',
            self::ZMW => 'ZK',
            self::KES => 'KSh',
            self::GHS => '₵',
            self::DZD => 'د.ج',
            self::MAD => 'د.م.',
            self::ETB => 'ብር',
            self::XAF, self::XOF => 'Fr',

            // Middle Eastern currencies
            self::AED => 'د.إ',
            self::SAR, self::YER, self::IRR, self::OMR, self::QAR => '﷼',
            self::KWD => 'د.ك',
            self::BHD => 'د.ب',
            self::JOD => 'د.ا',
            self::LBP => 'ل.ل',
            self::IQD => 'ع.د',
            self::SYP => 'ل.س',
            self::AFN => '؋',
        };
    }
}
