<?php
  
  namespace App\Http\Controllers\Site;
  
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Models\Pagamento;
use App\Models\Consulta;
use App\Models\Fatura;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class PagamentoController extends \App\Http\Controllers\Controller
{
  
    private $gateway;
  
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
    }
  
    /**
     * Call a view.
     */
    /**
     * Initiate a payment on PayPal.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function charge(Request $request)
    {
        
        if($request->input('submit'))
        {
            //dd($request);
            try {
               $response = $this->gateway->purchase(array(
                    'amount' => $request->amount,
                    'currency' => env('PAYPAL_CURRENCY'),
                    'returnUrl' => route('sgcf.site.success'),
                    'cancelUrl' => route('sgcf.site.error'),
                ))->send();
           
                if ($response->isRedirect()) {
                    $response->redirect(); // this will automatically forward the customer
                } else {
                    // not successful
                    //dd("Foi");
                    return $response->getMessage();
                }
            } catch(Exception $e) {
                //dd("foi");
                return $e->getMessage();
            }
        }
    }
  
    /**
     * Charge a payment and store the transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function success(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
          
            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $arr_body = $response->getData();
          
                // Insert transaction data into the database
                $payment = new Payment;
                $payment->payment_id = $arr_body['id'];
                $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr_body['state'];
                $payment->save();
          
                return "Payment is successful. Your transaction id is: ". $arr_body['id'];
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Transaction is declined';
        }
    }
  
    /**
     * Error Handling.
     */
    public function error()
    {
        return 'User cancelled the payment.';
    }
    public function gerarGuia($id){
        $data['guia']=fh_horarios()->where('id',$id)->first();
        //dd($data['guia']);
        $data['medico']=fh_medicos()->where('id',$data['guia']->id_medico)->first();
        $data['hospital']=fh_hospital()->where('id',$data['medico']->hospital_id)->first();
       // dd($data['rupe']);
        $html = view("site/guia/index",$data);
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $mpdf->AddPage();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Guia de Pagamento Nº".$data['guia']->id."/2024" . ".pdf", "D");
    }

    public function efectuarPagamento(Request $request,$id){
        try{
            //dd(fh_paciente_id(Auth::id()));
            $horario=fh_horarios()->where('id',$id)->first();
            $fatura=Fatura::create([
                'total'=>$horario->preco,
                'data'=>Carbon::now(),
                'paciente_id'=>fh_paciente_id(Auth::id())->id
            ]);
            Pagamento::create([
                'valor'=>$horario->preco,
                'id_fatura'=>$fatura->id,
                'comprovativo'=>upload($request->comprovativo),
                'guia'=>upload($request->guia)
            ]);
            Consulta::create([
                'paciente_id'=>fh_paciente_id(Auth::id())->id,
                'horario_id'=>$id,
                'estado'=>2,
                'fatura_id'=>$fatura->id
            ]);
            return redirect()->back()->with('pagamento.create.success',1);
        }catch(Throwable $th){
            throw $th;
            dd($th);
            
            return redirect()->back()->with('pagamento.create.error',1);
        }
    }
}