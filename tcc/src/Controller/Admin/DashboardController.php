<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Aws\S3\S3Client;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Documento;
use App\Entity\Index;
use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use setasign\Fpdi\Tcpdf\Fpdi;
use setasign\Fpdi\PdfReader;
use propa\tcpdi\tcpdi;

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'inicial')]
    public function home(): Response
    {
        
        return $this->redirectToRoute('app_tcc');


    }

    #[Route('/logs', name: 'log')]
    public function log(Request $request,ManagerRegistry $doctrine): Response
    {
        $pagina = 'log';
        $index_all =  $doctrine->getRepository(Index::class)->findAll();
        $logs =  $doctrine->getRepository(Log::class)->findAll();
        
        return $this->render('tcc/log.html.twig', [
            'logs' => $logs,
            'pagina' =>$pagina,
            'index_all' => $index_all
           
        ]);
    }
    
    #[Route('/tcc', name: 'app_tcc')]
    public function indexar(Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $documentos =  $doctrine->getRepository(Documento::class)->findBy(['indexx' => null]);
        $index_all =  $doctrine->getRepository(Index::class)->findAll();
        $erro = '';
        $ii=0;
        $pagina = 'index';
        $p = '';
        $link = '';
        $mx = 0;
        $xy = 0 ; 
        $yz = 0 ; 
        $ay = 0 ;
        $ky = 0 ;
        $pdf ='';
        $pagina_h4 ='Documento(s) para indexar';
        $nome_menu_ = '';
        $index_tipo='';
        $uuid = Uuid::v4();
        $user = $this->getUser();
        $user_nome= $user->getEmail();
        $pasta_user=$user_nome.'/';
        $arr = [];
        $filename = $uuid . '.pdf';
        $arrr=0;
        $index_find = null;
        $dt = '';
        $clientS3 = new  S3Client([
                   
                ]);
       

        if(isset($_POST["dt"]))
        {   

            $documentos =  $doctrine->getRepository(Documento::class)->findBy(['indexx' => $_POST["dt"]]);
            $index_find =  $doctrine->getRepository(Index::class)->find($_POST["dt"]);
            $pagina =$index_find->getTipo();
            $pagina_h4 ='Documento(s) do tipo ( '.$index_find->getTipo().' )';
            
            
        }
        if(isset($_POST["botao_export"]))
        {
        
            // PDF
            $files = $_FILES['file']['tmp_name'];
            
            if (file_exists($user_nome)) {
                    
            }
            
            else{
             mkdir($pasta_user, 0777, true);
            }
           

            $total_count = is_countable( $files ) ? count( $files ) : 0;
            for( $i=0 ; $i < $total_count ; $i++  ) { 

                $ii++;       
                $tmpFilePath =  $_FILES['file']['tmp_name'][$i];
                $nomes = $i . '.pdf';
                move_uploaded_file($tmpFilePath,$pasta_user.$nomes);
                $arr[] = $nomes;
            

            }


            
            
            foreach ($files as $file) {

                
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($pasta_user.$arr[$arrr]);
                $pages = $pdf->getPages();
                $page  = $pages[0];
                $text = $page->getText();
                ##$imagick = new \Imagick();
                #$imagick->pingImage($pasta_user.$arr[$arrr]);
                #$num5= $imagick->getNumberImages();
               # $filecontent = file_get_contents($nomes);



                $doc=$arr[$arrr];
             
                
            /*    if (preg_match("/^%PDF-1.5/", $filecontent)) { 
                     
                    dd($arr[$arrr] .' em alguma momento foi editado  e não se encontra mais no padrão PDF/A 1.4, infelizmente o sistema não consegue assinar  PDF/A 1.5  ');
                    
                    return $this->render('cadastro/index.html.twig', array(
                        'form' => $form->createView(),
        
                ));
                
                } 
                
                if (preg_match("/^%PDF-1.6/", $filecontent)) {
                    
                    dd($arr[$arrr] .'  em alguma momento foi editado  e não se encontra mais no padrão PDF/A 1.4, infelizmente o sistema não consegue assinar  PDF/A 1.6  ');
                    
                    return $this->render('cadastro/index.html.twig', array(
                        'form' => $form->createView(),
        
                ));
                }
                
                if (preg_match("/^%PDF-1.7/", $filecontent)) {  
                    dd($arr[$arrr] .'  em alguma momento foi editado  e não se encontra mais no padrão PDF/A 1.4, infelizmente o sistema não consegue assinar  PDF/A 1.7  ');
                    return $this->render('cadastro/index.html.twig', array(
                        'form' => $form->createView(),
        
                ));
                }
                
                if (preg_match("/^%PDF-1.8/", $filecontent)) { 
                    dd($arr[$arrr] .'   em alguma momento foi editado  e não se encontra mais no padrão PDF/A 1.4, infelizmente o sistema não consegue assinar  PDF/A 1.8 ');
                        return $this->render('cadastro/index.html.twig', array(
                            'form' => $form->createView(),
        
                ));
                    
                }
                
                if (preg_match("/^%PDF-1.9/", $filecontent)) {  
                   dd($arr[$arrr] .'   em alguma momento foi editado  e não se encontra mais no padrão PDF/A 1.4, infelizmente o sistema não consegue assinar  PDF/A 1.9');
                    return $this->render('cadastro/index.html.twig', array(
                        'form' => $form->createView(),
        
                ));
                }
                */
                
                $arrr++;
                
                $cert = 'certicadoVR.crt';
                
                
                //Informações da assinatura - Preencha com os seus dados
                $info = array(
                   'Name' => 'ARQUIVOS ORGANIZACÃO E GESTÃO DOCUMENTAL',
                   'Location' => 'VOLTA REDONDA',
                   'Reason' => '26157471000100',
                   'ContactInfo' => 'www.arquivosdoc.com.br',
                );

                $pdf = new Fpdi();
                $pdf->SetAutoPageBreak(TRUE, -3);
                
              
                
                $numPages = $pdf->setSourceFile($pasta_user.$doc);
                
                 
                 

                for ($i=1; $i <= $numPages; $i++) {
             
                    
                    $tplId = $pdf->importPage($i);
                    $s = $pdf->getTemplatesize($tplId);
                    $pdf->AddPage($s['orientation'], $s);
                    $pdf->useTemplate($tplId);
                   
                  }
                
              
                $pdf->setSignatureAppearance(160, 238, 40 ,40);
                $pdf->setSignature('file://'.$cert, 'file://'.realpath($cert), '123456','', 2, $info);

                
                if ($s['orientation'] == 'P') {
                    $pdf->Image('C:/xampp8-2/htdocs/tcc/public/img/removebg2.png',70, 230, 40 ,40 ,'PNG','https://verificador.staging.iti.br');
                }

                if ($s['orientation'] == 'L') {
                   $pdf->Image('C:/xampp8-2/htdocs/tcc/public/img/removebg2.png',70, 165, 40 ,40 ,'PNG','https://verificador.staging.iti.br');
                }



                $pdf->Output('C:/xampp8-2/htdocs/tcc/public/'.$pasta_user.$filename, 'F');
                
                
       
                $caminho = 'TCC/';
                $response = $clientS3->putObject(array(
                    'Bucket' => "arquivosdoc",
                    'Key'    => $caminho . $filename,
                    'SourceFile' => $pasta_user.$filename,
                    'ContentDisposition'=>'inline',
                    'ContentType'=>'application/pdf'
                ));

                

        
                $image ='https://arquivosdoc.s3-sa-east-1.amazonaws.com/'.$caminho . $filename;
                $registro = new Documento();
                $registro->setNome($text);  
                $registro->setImage($image);
                $registro->setUser($user);
                $registro->setQtd(0);
                $entityManager->persist($registro);
                $entityManager->flush();
                $erro = "ok";
                if ($arrr>1) {$p =  $arrr .' DOCUMENTOS EXPORTADOS , ASSINADOS E EXTRAÍDOS TEXTOS DAS CAPAS COM SUCESSO! ESTÃO PRONTO PARA INDEXAÇÃO.' ;}
                if ($arrr==1) {$p =  $arrr .' DOCUMENTO EXPORTADO , ASSINADO E EXTRAÍDO TEXTO DA CAPA COM SUCESSO! ESTÁ PRONTO PARA INDEXAÇÃO.' ;}
                $log = new Log();
                $log->setNome('EXPORTOU '.$arrr.' DOCUMENTO(S)');  
                $log->setUser($this->getUser());
                $entityManager->persist($log);
                $entityManager->flush();

            }
        
        }
        if(isset($_POST["botao_index"])){
            
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id"]);
            $link = $pdf->getImage();
            $xy = 1 ;
        }
        if(isset($_POST["botao_index_edit"])){
            
            $yz = 0 ;
            $xy = 1 ;
            $ay = 1 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id"]);
            $index_tipo =  $doctrine->getRepository(Index::class)->find($_POST["id_index"]);
            $link = $pdf->getImage();
        }
        if(isset($_POST["botao_volta"])){

            $xy = 0 ;
            $yz = 0 ;
        }
        if(isset($_POST["botao_inserir"])){

            $yz = 1 ;
            $xy = 1 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $link = $pdf->getImage();

        }
        if(isset($_POST["botao_salva"])){
            $yz = 1 ;
            $reg= new Index();
            if(isset($_POST["index1"])){$reg->setIndex1($_POST["index1"]);}
            if(isset($_POST["index2"])){$reg->setIndex2($_POST["index2"]);}
            if(isset($_POST["index3"])){$reg->setIndex3($_POST["index3"]);}            
            if(isset($_POST["index4"])){$reg->setIndex4($_POST["index4"]);}        
            if(isset($_POST["index5"])){$reg->setIndex5($_POST["index5"]);}     
            if(isset($_POST["index6"])){$reg->setIndex6($_POST["index6"]);}
            if(isset($_POST["index7"])){$reg->setIndex7($_POST["index7"]);}
            if(isset($_POST["index8"])){$reg->setIndex8($_POST["index8"]);}
            if(isset($_POST["index9"])){$reg->setIndex9($_POST["index9"]);}
            if(isset($_POST["index10"])){$reg->setIndex10($_POST["index10"]);}

            if(isset($_POST["tipo"])){
                if(isset($_POST["index1"])){
                    $reg->setTipo($_POST["tipo"]);
                    $entityManager->persist($reg);
                    $entityManager->flush();
                    $log = new Log();
                    $log->setNome('INSERIU TIPO DE DOCUMENTO');  
                    $log->setUser($this->getUser());
                    $entityManager->persist($log);
                    $entityManager->flush();
                    $yz = 0 ;
                    $erro = 'ok';
                    $p = 'tipo de documento '.$_POST["tipo"].'salva com sucesso';
                }
            }

            if(!isset($_POST["tipo"])){
                $erro = 'erro';
                $p = 'Valores vazios inserir o tipo'; 
            }

            if(!isset($_POST["index1"])){
                $erro = 'erro';
                $p = 'Valores vazios inserir pelo menos um indexador'; 
            }

            
            $xy = 1 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $link = $pdf->getImage();
        }
        if(isset($_POST["index_button"])){
            
            
            $yz = 0 ;
            $xy = 1 ;
            $ay = 1 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $index_tipo =  $doctrine->getRepository(Index::class)->find($_POST["index_button"]);
            $link = $pdf->getImage();
        }
        if(isset($_POST["botao_doc"])){
            
            
            $yz = 0 ;
            $xy = 1 ;
            $ay = 1 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $index_tipo =  $doctrine->getRepository(Index::class)->find($_POST["id_index"]);
            $index_tipo_tipo =  $index_tipo->getTipo();
            $link = $pdf->getImage();
            if(isset($_POST["doc1"])){$pdf->setIndex1($_POST["doc1"]);}
            if(isset($_POST["doc2"])){$pdf->setIndex2($_POST["doc2"]);}
            if(isset($_POST["doc3"])){$pdf->setIndex3($_POST["doc3"]);}
            if(isset($_POST["doc4"])){$pdf->setIndex4($_POST["doc4"]);}
            if(isset($_POST["doc5"])){$pdf->setIndex5($_POST["doc5"]);}
            if(isset($_POST["doc6"])){$pdf->setIndex6($_POST["doc6"]);}
            if(isset($_POST["doc7"])){$pdf->setIndex7($_POST["doc7"]);}
            if(isset($_POST["doc8"])){$pdf->setIndex8($_POST["doc8"]);}
            if(isset($_POST["doc9"])){$pdf->setIndex9($_POST["doc9"]);}
            if(isset($_POST["doc10"])){$pdf->setIndex10($_POST["doc10"]);}

            if(isset($_POST["doc1"])){
                $pdf->setUpdateAt(new \DateTimeImmutable('America/Sao_Paulo'));
                $pdf->setUser($user);
                $pdf->setIndexx($index_tipo);
                $entityManager->flush();
                $log = new Log();
                $log->setNome('DOCUMENTO COM ID '.$pdf->getId().' FOI INDEXADO');  
                $log->setUser($this->getUser());
                $entityManager->persist($log);
                $entityManager->flush();
                $erro = 'ok';
                $p =  $index_tipo_tipo.' indexado com sucesso';
            }

           
            
           
        }     
        if(isset($_POST["botao_cancel"])){
            $yz = 0 ;
            $xy = 1 ;
            $ay = 0 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $link = $pdf->getImage();
            
        }
        if(isset($_POST["botao_cancel_index"])){
          
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $link = $pdf->getImage();
            $xy = 1 ;

            $pdf->setIndex1('');
            $pdf->setIndex2('');
            $pdf->setIndex3('');
            $pdf->setIndex4('');
            $pdf->setIndex5('');
            $pdf->setIndex6('');
            $pdf->setIndex7('');
            $pdf->setIndex8('');
            $pdf->setIndex9('');
            $pdf->setIndex10('');

            if(isset($_POST["doc1"])){
                $pdf->setUpdateAt(new \DateTimeImmutable('America/Sao_Paulo'));
                $pdf->setUser($user);
                $pdf->setIndexx(NULL);
                $entityManager->flush();
                $log = new Log();
                $log->setNome('DOCUMENTO COM ID  '.$pdf->getId().' FOI LIMPADA SUA INDEXAÇÃO');  
                $log->setUser($this->getUser());
                $entityManager->persist($log);
                $entityManager->flush();
                
                $erro = 'ok';
                $p =  'limpeza de indexação com sucesso';
            }

            
            
        }
        if(isset($_POST["delet"])){
           
            $ky = 1 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["delet"]);
            $documentos = $doctrine->getRepository(Documento::class)->findBy(['id' => $_POST["delet"]]);
            $index_find =  $doctrine->getRepository(Index::class)->find($pdf->getIndexx());
            $pagina =$index_find->getTipo();
            $pagina_h4 ='Documento(s) do tipo ( '.$index_find->getTipo().' )';
                        
        }
        if(isset($_POST["delet_cancel"])){
            $ky = 0 ;
        }
        if(isset($_POST["delet_sim"])){
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id"]);
            
            $id_pd = $pdf->getId();
            $entityManager->remove($pdf);
            $entityManager->flush();
            $log = new Log();
            $log->setNome('DOCUMENTO COM ID  '.$pdf->getId().' FOI EXCLUÍDO');  
            $log->setUser($this->getUser());
            $entityManager->persist($log);
            $entityManager->flush();
            $erro = 'ok';
            $p = 'Documento com id '.$id_pd.' excluido com sucesso '; 
        }
        if(isset($_POST["index_edit"])){
            $yz = 0 ;
            $xy = 1 ;
            $ay = 2 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $index_tipo =  $doctrine->getRepository(Index::class)->find($_POST["id_index"]);
            $link = $pdf->getImage();
        }
        if(isset($_POST["index_delet"])){
            
            $yz = 0 ;
            $xy = 1 ;
            $ay = 1 ;
            $mx = 1 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $index_tipo =  $doctrine->getRepository(Index::class)->find($_POST["id_index"]);
            $link = $pdf->getImage();
            $index_tipo_nome = $index_tipo->getTipo();
        }
        if(isset($_POST["delet_sim_index"])){
            

            $yz = 0 ;
            $xy = 1 ;
            $ay = 2 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $index_tipo =  $doctrine->getRepository(Index::class)->find($_POST["id_index"]);
            $link = $pdf->getImage();
            $index_tipo_nome = $index_tipo->getTipo();
            $index_tipo_id = $index_tipo->getId();
            $docs_ =  $doctrine->getRepository(Documento::class)->findBy(['indexx'=> $index_tipo_id ]);
            
            if ($docs_ == null) {
                $entityManager->remove($index_tipo);
                $entityManager->flush();
                $log = new Log();
                $log->setNome('TIPO COM ID  '.$index_tipo_id .' FOI EXCLUÍDO');  
                $log->setUser($this->getUser());
                $entityManager->persist($log);
                $entityManager->flush();
                $erro = "ok";
                $p =  'Indexadores do tipo `  '.$index_tipo_nome.'`   foi  excluido com sucesso!';
            }

            if ($docs_ != null) {
                $erro = "erro";
                $p =  'Indexadores do tipo `  '.$index_tipo_nome.'`   não pode ser excluido contém documento indexado por ele';
            }

           
        }
        if(isset($_POST["btn_index_edit"])){
            $yz = 0 ;
            $xy = 1 ;
            $ay = 2 ;
            $pdf =  $doctrine->getRepository(Documento::class)->find($_POST["id_pdf"]);
            $index_tipo =  $doctrine->getRepository(Index::class)->find($_POST["id_index"]);
            $link = $pdf->getImage();
            $index_tipo_nome = $index_tipo->getTipo();
            if(isset($_POST["index1_"])){$index_tipo->setIndex1($_POST["index1_"]);}
            if(isset($_POST["index2_"])){$index_tipo->setIndex2($_POST["index2_"]);}
            if(isset($_POST["index3_"])){$index_tipo->setIndex3($_POST["index3_"]);}            
            if(isset($_POST["index4_"])){$index_tipo->setIndex4($_POST["index4_"]);}        
            if(isset($_POST["index5_"])){$index_tipo->setIndex5($_POST["index5_"]);}     
            if(isset($_POST["index6_"])){$index_tipo->setIndex6($_POST["index6_"]);}
            if(isset($_POST["index7_"])){$index_tipo->setIndex7($_POST["index7_"]);}
            if(isset($_POST["index8_"])){$index_tipo->setIndex8($_POST["index8_"]);}
            if(isset($_POST["index9_"])){$index_tipo->setIndex9($_POST["index9_"]);}
            if(isset($_POST["index10_"])){$index_tipo->setIndex10($_POST["index10_"]);}
            $entityManager->flush();
            $log = new Log();
                $log->setNome('TIPO   '.$index_tipo_nome .' FOI EDITADO');  
                $log->setUser($this->getUser());
                $entityManager->persist($log);
                $entityManager->flush();
            $erro = "ok";
            $p =  'Indexadores do tipo `  '.$index_tipo_nome.'`   foi editado com sucesso!';
               

        }
        
        return $this->render('tcc/index.html.twig', [
            'documentos' => $documentos,
            'xy' => $xy,
            'yz' => $yz,
            'ay'=>$ay,
            'link' => $link,
            'pdf'=>$pdf,
            'p'=>$p,
            'erro'=>$erro,
            'index_all'=>$index_all,
            'index_tipo'=>$index_tipo,
            'ky'=>$ky,
            'pagina' => $pagina,
            'pagina_h4' =>$pagina_h4,
            'index_find'=>$index_find,
            'mx'=>$mx
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('IndexDoc')
            ->setFaviconPath('./img/icon.png');   
     }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
