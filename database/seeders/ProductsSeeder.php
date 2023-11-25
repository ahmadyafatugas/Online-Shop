<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::create([
            "title" => "JT - HEADSET MACARON",
            "description" => "Drive Unit : 15mm / 6u (true copper ring horn)
            Sensitivity : 110dB
            Frequency Response Range : 20Hz--20KHz",
            "url" => "/images/product/headset1.png",
            'price' => 4424
        ]);

        Products::create([
            "title" => "Headset Hansfree R10",
            "description" => "Perangkat
            Warna: Hitam, Putih
            Jenis: In-ear
            Konektor: jek audio 3.5mm
            Material Coil: Aluminium yang melayani tembaga
            Inti kabel: Kabel tembaga yang dienamel + serat Kevlar
            Panjang Kabel: 1,25 m
            Berat: 13,5 g
            Berat yang Didukung: 10 kg",
            "url" => "/images/product/headset2.png",
            'price' => 5900
        ]);

        Products::create([
            "title" => "ECLE Wired Earphone",
            "description" => "• Jenis earphone: In-ear earphone ringan

            • Panjang Kabel 1.2 M
            
            • Satu tombol universal dengan mikrofon
            
            • Frekuensi respons 20-20 kHz
            
            • Kompatibel dengan semua perangkat Android dan iOS
            
            • Sensitivitas 102dB
            
            • Jenis Plug: 3.5mm
            
            • Nilai daya: 3mW
            
            • Speaker Impedansi: 18 ohms
            
            • Isi box: 1 unit ECLE In-ear Headphone ",
            "url" => "/images/product/headset3.png",
            'price' => 9999
        ]);

        Products::create([
            "title" => "KAOS BAND THE MISFITS",
            "description" => "- Model kaos UNISEX ( Bisa dipakai cowok dan cewek )
            - Bahan kaos menggunakan COTTON COMBED 30s Paling Tipis
            - Sablon menggunakan Digital Printing High Quality",
            "url" => "/images/product/baju1.png",
            'price' => 59900
        ]);

        Products::create([
            "title" => "KAOS BAND BLACK SABBATH",
            "description" => "WARNA BAHAN : HITAM
            MATERIAL : KATUN POLY 24S
            SABLON : PLASTISOL
            JAHITAN : STANDAR DISTRO",
            "url" => "/images/product/baju2.png",
            'price' => 57900
        ]);

        Products::create([
            "title" => "KAOS BAND SOAD",
            "description" => "-Bahan 100 % COTTON COMBED 30S .halus dan nyaman, bukan spandex yaa bos
            -Cutting kaos Standart UNISEX ( Cewek cowok bisa pakai)
            -Menggunakan Sablon Digital High Quality
            -Hasil sablon 90% sama dengan foto",
            "url" => "/images/product/baju3.png",
            'price' => 60000
        ]);

        Products::create([
            "title" => "Laptop HP",
            "description" => "Processor : Intel Celeron N4500 (up to 2.8 GHz burst frequency, 4 MB L3 cache, 2 cores, 2 threads)

            Graphics : Intel UHD Graphics
            
            Display : 14 diagonal, HD (1366 x 768), micro-edge, BrightView, 250 nits, 45% NTSC
            
            Memory : 8 GB DDR4-3200 MHz RAM (2 x 4 GB)
            
            Storage : 256 GB PCIe NVMe M.2 SSD
            
            Keyboard : Full-size, backlit, natural silver keyboard
            
            Camera : HP True Vision 720p HD camera
            
            Operating System : Windows 11 OHS
            
            Garansi Unit: Garansi resmi HP 2 Tahun",
            "url" => "/images/product/laptop1.png",
            'price' => 4799000
        ]);

        Products::create([
            "title" => "Laptop Asus VivoBook",
            "description" => "Panel Size : 14.0 (16:9) FHD (1920x1080) Anti-Glare 60Hz Panel with 45% NTSC
            Processor : Intel® Celeron® N4020 Processor 1.1 GHz (4M Cache, up to 2.8 GHz, 2 cores)
            Intergrated GPU : Intel® UHD Graphics 600
            Total System Memory : 4GB DDR4 SO-DIMM
            Storage : 256GB M.2 NVMe™ PCIe® 3.0 SSD + HDD housing for storage expansion",
            "url" => "/images/product/laptop2.png",
            'price' => 4349000
        ]);

        Products::create([
            "title" => "Laptop Acer Aspire",
            "description" => "Specification :
                - prossesor Intel Core i3
                - Windows 10
                - layar 14 inch
                - RAM 4GB DDR4
                - HDD 500GB//1TB
                - Intel UHD Graphics
                - Bluetooth
                - HDMI port with HDCP support
                - Wi-Fi
                - HD webcam with:1280 x 720 resolution, 720p HD audio/video recording
                - Two built-in stereo speakers",
            "url" => "/images/product/laptop3.png",
            'price' => 3800000
        ]);

        Products::create([
            "title" => "Realme C53",
            "description" => "Ukuran layar: 6.74 inci, 1080 x 2400 pixels, IPS LCD,90Hz,650nits
            Memori: RAM 6 GB, ROM 128 GB, MicroSDXC Slot
            Sistem operasi: Android 13, Realme UI T
            CPU: Unisoc Tiger T612 (12 nm), Octa-core (2x1.8 GHz Cortex-A75 & 6x1.8 GHz Cortex-A55)
            GPU: Mali-G57
            Kamera: 50 MP f/2.2 AF (wide), 0.3 MP f/2.8 (depth); Depan 8 MP f/2.0 (wide)
            SIM: Dual SIM (Nano-SIM, dual stand-by)
            Baterai: Non-removable Li-Po 5000 mAh
            Berat: 182 gr",
            "url" => "/images/product/handphone1.png",
            'price' => 1918000
        ]);

        Products::create([
            "title" => "Samsung Galaxy S21 FE",
            "description" => "Dimensi dan bobot 
            74,5 x 155,7 x 7,9 mm, 177 gram 
            Layar 
            Dynamic AMOLED 6,4 inci Full HD Plus, refresh rate 120 Hz, touch sampling rate 240 Hz,Eye Comfort Shield dengan AI based blue light control
            
            Chipset 
            Chipset dengan fabrikasi 5nm. 
            Exynos 2100 5G
            
            CPU dan GPU CPU: 
            5nm 64-bit Octa-Core processor 
            GPU: Adreno 660
            
            RAM dan memori penyimpanan 
            8 GB/256 GB",
            "url" => "/images/product/handphone2.png",
            'price' => 7650000
        ]);

        Products::create([
            "title" => "OPPO Reno8 T",
            "description" => "PENYIMPANAN

            Kapasitas RAM dan ROM: 8GB+256GB
            
            Jenis RAM: LPDDR4X @ 2133MHz 2 x 16-bit
            
            Spesifikasi ROM: UFS2.2 @ 2 Jalur HS-Gear3
            
            Kartu Penyimpanan: Didukung
            
            USB OTG: Didukung",
            "url" => "/images/product/handphone3.png",
            'price' => 3489000
        ]);
    }
}
