<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Install</title>
</head>
<body>
<div class="container-fluid">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Configuration</div>
                <div class="card-body">
                    <form action="./?page=2" method="post">
                        <table class="table">
                            <tr>
                                <td width="70%">Local Server IP
                                </td>
                                <td width="30%"><input type="text" name="pthost" class="form-control"
                                    >
                                </td>
                            </tr>
                        </table>

                        <table class="table">
                            <tr>
                                <td width="70%">MySQL Host</td>
                                <td width="30%"><input type="text" name="mshost" class="form-control"
                                    >
                                </td>
                            </tr>
                        </table>

                        <table class="table">
                            <tr>
                                <td width="70%">MySQL Username</td>
                                <td width="30%"><input type="text" name="msuser" class="form-control"
                                    >
                                </td>
                            </tr>
                        </table>

                        <table class="table">
                            <tr>
                                <td width="70%">MySQL Password</td>
                                <td width="30%"><input type="password" name="mspass" class="form-control"
                                    ></td>
                            </tr>
                        </table>

                        <table class="table">
                            <tr>
                                <td width="70%">CMS Database <span style="font-size:10px; font-weight:none;">(Database for CMS tables).</span>
                                </td>
                                <td width="30%"><input type="text" name="cmsdb" class="form-control">
                                </td>
                            </tr>
                        </table>

                        <table class="table">
                            <tr>
                                <td width="70%">Account Database <span style="font-size:10px; font-weight:none;">(Database where Account tables are located).</span>
                                </td>
                                <td width="30%"><input type="text" name="accdb" class="form-control">
                                </td>
                            </tr>
                        </table>



                        <table class="table">
                            <tr>
                                <td width="70%"><b>Title:</b> The global website title.</td>
                                <td width="30%"><input type="text" name="global_title" value="" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%"><b>Email Activation:</b> Should registration require email
                                    activation?
                                </td>
                                <td width="30%"><select name="email_act" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%"><b>Login:</b> Should the login system be enabled or disabled?</td>
                                <td width="30%"><select name="login" class="form-control">
                                        <option value="1">Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%"><b>Copyright:</b> Your server's name for website copyright settings.
                                </td>
                                <td width="30%"><input type="text" name="cright" value="" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%"><b>Realmlist:</b> Your server's realmlist.</td>
                                <td width="30%"><input type="text" name="realm" value="" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%"><b>Server Email:</b> Email Address used to send emails from the
                                    website to users.
                                </td>
                                <td width="30%"><input type="text" name="semail" value="" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%"><b>Domain:</b> Your server's domain without http://.</td>
                                <td width="30%"><input type="text" name="domain" value="" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%"><b>Server Title:</b> Your server's name for email topics/subjects.
                                </td>
                                <td width="30%"><input type="text" name="stitle" value="" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%"><b>Expansion:</b> Which expansion should your users be registered
                                    with?
                                </td>
                                <td width="30%"><select name="expansion" class="form-control">
                                        <option value="2">Wrath of the Lich King</option>
                                        <option value="3">Cataclysm</option>
                                        <option value="4">Mists of Pandaria</option>
                                    </select></td>
                            </tr>
                        </table>





                        <table class="table">
                            <tr>
                                <td width="70%">SOAP Host <span style="font-size:10px; font-weight:none;">(Domain or IP (Server) without the http:// or ending /).</span>
                                </td>
                                <td width="30%"><input type="text" name="soaphost" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">SOAP User <span style="font-size:10px; font-weight:none;">(Account will be given GM level 4).</span>
                                </td>
                                <td width="30%"><input type="text" name="soapuser" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">SOAP Password</td>
                                <td width="30%"><input type="password" name="soappass" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">Paypal Email</td>
                                <td width="30%"><input type="text" name="pemail" class="form-control" AutoComplete="off">
                                </td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">Paypal Currency</td>
                                <td width="30%"><select name="pcur" class="form-control">
                                        <option value="1">USD</option>
                                        <option value="2">EURO</option>
                                    </select></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">Realm Name</td>
                                <td width="30%"><input type="text" name="rname" class="form-control" AutoComplete="off">
                                </td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">Realm Description</td>
                                <td width="30%"><input type="text" name="rtype" class="form-control" AutoComplete="off">
                                </td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">Realm Character Database</td>
                                <td width="30%"><input type="text" name="rcdb" class="form-control" AutoComplete="off">
                                </td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">Realm Port</td>
                                <td width="30%"><input type="text" name="rport" class="form-control" AutoComplete="off">
                                </td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">Realm SOAP Port</td>
                                <td width="30%"><input type="text" name="soapport" class="form-control"
                                                       AutoComplete="off"></td>
                            </tr>
                        </table>


                        <table class="table">
                            <tr>
                                <td width="70%">Install</td>
                                <td width="30%"><input class="btn btn-success" type="submit" name="save3" value="Install"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>