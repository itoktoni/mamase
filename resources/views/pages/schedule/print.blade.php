<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Schedule Check {{ $master->field_primary ?? '' }}</title>

	<link rel="stylesheet" href="{{ asset('assets/css/print.css', false) }}">

	<style>
	body, h1, h2, h3, h4, h5, h6, span, p, a{
		font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif !important;
	}
	</style>

</head>

<body>
    <div id="page">

        <div id="container">
            <table cellpadding="" 5 cellspacing="0" width="100%">
                <tr class="title">
                    <td align='left' colspan='8' valign='middle'>
                        <h1 id="headline">
                            SCHEDULE
                        </h1>
                    </td>
                </tr>
                <tr class="contact">
                    <td colspan='8'>
                        <strong>
                            Name : {{ $master->field_name ?? '' }}
                        </strong><br>
                        <strong>
                            No. ID : ({{ strtoupper($master->field_primary) ?? '' }})
                        </strong>
                        <p>
                            Description : {{ $master->field_description ?? '' }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        <strong>
                            Number : {{ $master->field_number ?? '' }}
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <strong>
                            Date &nbsp; &nbsp; &nbsp;  : {{ $master->field_date ?? '' }}
                        </strong>
                    </td>
                    <td colspan="4">
                        <strong>
                            Date Print : {{ date("Y-m-d") }}
                        </strong>
                    </td>
                </tr>
            </table>
        </div>
</body>

</html>
