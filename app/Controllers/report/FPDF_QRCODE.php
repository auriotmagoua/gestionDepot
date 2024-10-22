<?php

namespace App\Controllers;
set_time_limit(480);

class FPDF_QRCODE extends FPDF
{
   function printFthis($data){
        
        $this->SetFont('times', '','8');

        $this->Cell(0, 10, 'Numero : '.$data["idQrCode"], 0, 1, 'R');
        $this->Ln();

        // Ajouter un titre au this
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 10, $data["titre"], 'LTRB', 1, 'C');

        // Calculer la position de l'image en fonction de la hauteur actuelle du curseur
        $posY = $this->GetY();  // Obtenir la position actuelle en Y
        $this->Ln(10);  // Ajouter un espacement vertical après le titre

        // Définir les dimensions du QR code
        $qrCodeSize = 190;

        // Ajouter l'image QR code au this
        $this->Image(getenv('PICTURE_QRCODE').'/'.$data["image"], 10, $posY + 10, $qrCodeSize, $qrCodeSize, 'PNG');

        // Ajouter le cadre autour du QR code
        $this->Rect(10, $posY + 10, $qrCodeSize, $qrCodeSize);

        // Ajouter du texte après l'image QR code
        $this->SetY($posY + 220);  // Ajuster la position Y après l'image
        $this->SetTextColor(128, 0, 0);
        $this->Cell(0, 10, "NB : NE PAS TOUCHER CE DOCUMENT", 0, 1, 'C');

   }
}