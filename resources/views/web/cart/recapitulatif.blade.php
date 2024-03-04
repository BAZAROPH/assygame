@if (Cart::instance('shopping')->count() > 0)
    <aside class="col-lg-4 pt-4 pt-lg-0">
        <div class="cz-sidebar-static rounded-lg box-shadow-lg ml-lg-auto">
            <ul class="list-unstyled font-size-sm pb-2 border-bottom">
                <li class="d-flex justify-content-between align-items-center">
                    <span class="mr-2">Sous total : </span>
                    <span class="text-right sousTotal">
                        {{ devise(Cart::instance('shopping')->subtotal()) }}
                        @php($livraison = coutLivraison(Cart::instance('shopping')->content()))
                    </span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span class="mr-2">Frais d'expédition : </span>
                    <span class="text-right coutLivraison">
                        {{ devise($livraison) }}
                    </span>
                </li>
            </ul>
            <h3 class="font-weight-normal text-center my-4 totalCommande">
                {{ devise(Cart::instance('shopping')->total() + $livraison) }}
            </h3>
            {{--  <form class="needs-validation" method="post" novalidate>
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Promo code" required>
                    <div class="invalid-feedback">Please provide promo code.</div>
                </div>
                <button class="btn btn-outline-primary btn-block" type="submit">Apply promo code</button>
            </form>  --}}
            @if (url()->current() == url('panier'))
                <div class="text-center border-top">
                    @auth
                        {{-- <a class="btn btn-info btn-shadow btn-block mt-4" href="{{ url('mode-de-paiement') }}">
                            <i class="czi-bag font-size-lg mr-2"></i> Continuer
                        </a> --}}
                        <?php
                        try {
                        $cp->setTransId($id_transaction)
                            ->setDesignation($description_du_paiement)
                            ->setTransDate($date_transaction)
                            ->setAmount(Cart::instance('shopping')->total() + $livraison)
                            ->setCurrency($devise)
                            ->setDebug(true)// Valorisé à true, si vous voulez activer le mode debug sur cinetpay afin d'afficher toutes les variables envoyées chez CinetPay
                            ->setCustom($identifiant_du_payeur)// optional
                            ->setNotifyUrl($notify_url)// optional
                            ->setReturnUrl($return_url)// optional
                            ->setCancelUrl($cancel_url)// optional
                            ->displayPayButton($formName, $btnType, $btnSize);
                        } catch (Exception $e) {
                            print $e->getMessage();
                        }
                        ?>
                    @else
                        <a class="btn btn-info btn-shadow btn-block mt-4" href="{{ route('login') }}">
                            <i class="czi-bag font-size-lg mr-2"></i> Continuer
                        </a>
                    @endauth
                </div>
            @else
                @if (url()->current() == url('mode-de-paiement'))
                    <a href="https://cinetpay.com/demo" class="btn btn-info btn-block">
                        <i class="fa czi-card" aria-hidden="true"></i>
                        Payer
                    </a>
                @endif
            @endif
        </div>
    </aside>
@endif
