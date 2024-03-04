<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="background: #e5e5e5; padding: 30px;" >

<div style="max-width: 320px; margin: 0 auto; padding: 20px; background: #fff;">
	<h3>Une commande initiée via ASSYGAME :</h3>
	<div>{{ "COMMANDE du ".date("d/m/Y")." à ".date("h")."H" }}</div>
    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Option</th>
                <th>Quantité</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            {{foreach($request->produits as $k => $v)}}
            <tr>
                <th>{{ $v["produit_id"] }}</th>
                <th>{{ $v["option_id"] }}</th>
                <th>{{ $v["quantite"] }}</th>
                <th>{{ $v["montant"] }}</th>
            </tr>
            {{endforeach}}
        </tbody>
    </table>
    <div>Total : {{ $data['montant'] }}</div>
</div>

</body>
</html>
