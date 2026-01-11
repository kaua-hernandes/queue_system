<?php

if (!function_exists('showValidationError')) {
    function showValidationError($errors, $field)
    {
        if ($errors->has($field)) {
            return '<div class="text-sm italic text-red-500">' . $errors->first($field) . '</div>';
        }
        return '';
    }
}


if (!function_exists('showServerError')) {
    function showServerError()
    {
        if (session()->has('server_error')) {
            return '<div class="text-sm italic text-red-500">' . session()->get('server_error') . '</div>';
        }
        return '';
    }
}

if (!function_exists('getFormattedTicketNumber')) {
    function getFormattedTicketNumber($ticketNumber, $totalDigits, $prefix = null)
    {
        $result = '';

        $totalDigits = (int) $totalDigits;

        // prefix
        if ($prefix) {
            $result = $prefix;
        }

        // numbers
        if ($totalDigits > 0) {
            $result .= str_pad($ticketNumber, $totalDigits, '0', STR_PAD_LEFT);
        }

        return $result;
    }
}

if (!function_exists('getTicketStateText')) {
    function getTicketStateText($status)
    {
        $rules = [
            'waiting' => 'A aguardar',
            'called' => 'Chamado',
            'dismissed' => 'Dispensado',
            'non_attended' => 'Não atendido'
        ];

        return $rules[$status] ?? 'Desconhecido';
    }
}

if (!function_exists('getQueueStateIcon')) {
    function getQueueStateIcon($state)
    {
        $icon = [
            'active' => '<i class="fa-regular fa-circle-check text-green-700" title="Ativa"></i>',
            'inactive' => '<i class="fa-regular fa-circle-xmark text-red-700" title="Inativa"></i>',
            'done' => '<i class="fa-solid fa-ban text-slate-300" title="Concluída"></i>'
        ];

        return $icon[$state] ?? '';
    }
}

if (!function_exists('getQueueStateText')) {
    function getQueueStateText($state)
    {
        $rules = [
            'active' => 'Ativa',
            'inactive' => 'Inativa',
            'done' => 'Terminada'
        ];

        return $rules[$state] ?? 'Desconhecido';
    }
}
