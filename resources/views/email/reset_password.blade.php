<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <table width="100%" style="width: 100%">
        <tbody>
            <tr>
                <td>
                    <table width="570" align="center">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <img src="https://res.cloudinary.com/dvwsffyzc/image/upload/v1717855439/aer7ftzvs1gjiqdb56zh.png"
                                        style="margin-bottom: 40px; margin-top: 40px" width="120px" />
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: justify">
                                    <h1>Hello!</h1>
                                    <p>You are receiving this email because we received a password reset request for
                                        your account.</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <a href="{{ $url }}"
                                        style="margin-bottom: 16px; display: inline-block; padding: 12px 50px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px; background: rgb(57, 57, 206)">Reset Password</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: justify">
                                    {{-- <p>This password reset link will expire in 60 minutes.</p> --}}
                                    <p>If you did not request a password reset, no further action is required.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: justify">
                                    <p style="font-size: 16px; color: black; margin-top: 50px">Regards,</p>
                                    <p style="font-size: 16px; color: black;">Central AI</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: justify">
                                    <p>If you're having trouble clicking the "Reset Password" button, copy and paste the
                                        URL below into
                                        your web browser:</p>
                                    <p><a href="{{ $url }}">{{ $url }}</a></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>


        </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>

</body>

</html>
