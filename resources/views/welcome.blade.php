
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Koperasi Amanah Sejati</title>
        <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">

        <!-- stylesheets tailwind -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="{{ asset('assets/frontend/output.css') }}">

        <!-- alpine js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
        <!-- tailwindcss flag-icon  -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css" rel="stylesheet">

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('assets/frontend/style.css') }}">
        <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;700;800;900&display=swap"
        rel="stylesheet"> -->

    </head>

    <body id="home" class="  antialiased leading-normal tracking-wide 2xl:text-xl font-nunito  bg-white   text-slate-900"
        x-data="{ switcher: translationSwitcher() }">
        <!-- navbar  -->
        <nav x-data="{isOpen: false }" class="fixed top-0 z-50 w-full     ">
            <div id="navbar" class="px-6 py-6 mx-auto duration-300 bg-white  shadow-md ">
                <div class="lg:flex container mx-auto lg:items-center lg:justify-between">
                    <div class="flex items-center justify-between">
                        <!-- logo -->
                        <a href="/view/home.html" class="flex items-center text-black   mx-4 md:ml-6">
                            <img src="{{ asset('assets/img/logo.png') }}" class="md:w-14 md:h-14 w-12 h-12">

                            <div class="ml-3 text-[#0b3960]   ">
                                <strong
                                    class=" text-2xl md:text-3xl font-extrabold  tracking-wider uppercase">KOPERASI</strong>
                                <p class="text-[13px] md:text-[18px] text-[#0b3960] tracking-widest font-semibold  uppercase -mt-2
                                    relative">
                                    Amanah Sejati</p>
                            </div>
                        </a>
                        <!-- Mobile menu button -->
                        <div class="flex lg:hidden">
                            <button x-cloak @click="isOpen = !isOpen" type="button"
                                class="text-gray-200 hover:text-gray-400 focus:outline-none focus:text-gray-100 "
                                aria-label="toggle menu">
                                <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                                </svg>
                                <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                    <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']" class="absolute inset-x-0 z-20 w-full px-6 py-4 transition-all duration-300 ease-in-out bg-white   md:bg-none menu-navbar text-white lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto
                        lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center " id="list-menu">
                        <div class="flex flex-col -mx-6 lg:flex-row lg:items-center lg:mx-8 text-[16px]">
                            <a href="#home" class="px-3 py-2 mx-2 mt-2 text-gray-600 transition-colors active-menu duration-300 transform rounded-md
                                lg:mt-0 hover:text-[#00a2ff] ">Home</a>
                            <a href="#tentang" class="px-3 py-2 text-gray-600 mx-2 mt-2 transition-colors duration-300 transform rounded-md lg:mt-0
                                hover:text-[#00a2ff]   ">Tentang Kami</a>
                            @if (auth()->check())
                            <a href="{{ route('home') }}"
                                class="px-3 py-2 mx-2 mt-2 text-gray-600 transition-colors duration-300 transform rounded-md lg:mt-0 hover:text-[#00a2ff]       ">Dashboard</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out text-red-600"></i>
                                <span class="text-red-600">
                                    Logout
                                </span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="px-3 py-2 mx-2 mt-2 text-red-600 transition-colors duration-300 transform rounded-md lg:mt-0 hover:text-[#00a2ff]">
                                @csrf
                            </form>
                            @else
                                <a href="{{ route('login') }}" class="px-3 py-2 mx-2 mt-2 text-red-600 transition-colors duration-300 transform rounded-md lg:mt-0 hover:text-[#00a2ff]">Login</a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </nav>
        <!-- end navbar -->

        <!-- slider -->
        <section id="home">

            <div
                class="relative text-center pt-20 pb-40 overflow-hidden  bg-gradient-to-tl from-blue-900  to-cyan-400      md:bg-transparent     ">
                <svg id="visual" viewBox="0 0 900 450" class="w-full h-full absolute" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
                    <g>
                        <g transform="translate(781 121)">
                            <path d="M0 -102.1L88.4 -51L88.4 51L0 102.1L-88.4 51L-88.4 -51Z" stroke="#fff" fill="none"
                                stroke-width="2"></path>
                        </g>
                        <g transform="translate(565 197)">
                            <path d="M0 -16L13.9 -8L13.9 8L0 16L-13.9 8L-13.9 -8Z" stroke="#fff" fill="none"
                                stroke-width="2"></path>
                        </g>
                        <g transform="translate(42 9)">
                            <path d="M0 -55L47.6 -27.5L47.6 27.5L0 55L-47.6 27.5L-47.6 -27.5Z" stroke="#fff" fill="none"
                                stroke-width="2"></path>
                        </g>
                        <g transform="translate(866 344)">
                            <path d="M0 -21L18.2 -10.5L18.2 10.5L0 21L-18.2 10.5L-18.2 -10.5Z" stroke="#fff" fill="none"
                                stroke-width="2"></path>
                        </g>
                        <g transform="translate(593 420)">
                            <path d="M0 -87L75.3 -43.5L75.3 43.5L0 87L-75.3 43.5L-75.3 -43.5Z" stroke="#fff" fill="none"
                                stroke-width="2"></path>
                        </g>
                    </g>
                </svg>

                <div class=" w-full m-0 pt-3    ">
                    <div class="container   mx-auto flex flex-wrap flex-col md:flex-row items-center  ">
                        <!--Left Col-->
                        <div data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine" class="  mt-16 w-full md:w-3/6 justify-center items-start md:px-5 text-center md:text-right
                        px-4   z-30">
                            <p class="mt-2 text-3xl text-sh lg:text-5xl font-bold text-yellow-300 text-center md:text-right
                                ">
                                Koperasi Amanah Sejati
                            </p>
                            <p class=" my-2 leading-7 text-[16px] mb-8 text-sh text-white
                                text-center md:text-right ">
                                Selamat Datang di <span class="text-yellow-200">Koperasi Amanah Sejati</span>.
                                Software aplikasi untuk memudahkan pengelolaan
                                Koperasi. untuk mendekatkan layanan kepada anggota yang memiliki lokasi sebaran jauh
                                guna memberikan layanan yang lebih baik, lebih cepat dan lebih akurat.
                            </p>
                        </div>
                        <div data-aos="zoom-in-left" class="mt-16 w-full md:w-3/6 justify-center items-start md:px-5 text-center md:text-right
                        px-4   z-30">
                            <img src="{{ asset('assets/img/logo.png') }}" class="w-1/2 h-1/2 mx-auto img-sh">

                        </div>
                    </div>
                </div>
                <div class=" ">
                    <div class="custom-shape-divider-bottom-1691295679 bottom-0  ">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="h-[210px]" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="fill-[#ffffff4c]"></path>
                        </svg>
                    </div>
                    <div class="custom-shape-divider-bottom-1691295679 bottom-0 ">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="h-[140px]" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="fill-[#ffffff84]"></path>
                        </svg>
                    </div>
                    <div class="custom-shape-divider-bottom-1691295679 bottom-0">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="h-[80px]" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="fill-[#ffffffc9]"></path>
                        </svg>
                    </div>
                    <div class="custom-shape-divider-bottom-1691295679 bottom-0">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="h-[50px]" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="fill-[#ffffffcf]"></path>
                        </svg>
                    </div>

                </div>
            </div>
        </section>

        <!-- end slider -->

        <!-- tentang  -->
        <section id="tentang">
            <div class="container pt-32 mx-auto" x-data="{ tab: 'all' }">
                <h1 data-aos="fade-down"
                    class="mb-12 text-center font-sans text-4xl lg:text-5xl font-bold text-[#0b3960]   "
                    style="text-shadow:5px 5px 5px #38383863;">
                    Tentang Koperasi Amanah Sejati</h1>
            </div>


            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto mt-20 mb-32">
                <div data-aos="fade-left" class="col-span-1">
                    <img src="{{ asset('assets/img/struktur.svg') }}" alt=""
                        class="w-full h-full object-fill shadow-[5px_5px_10px_0px_#777] rounded-xl  ">
                </div>
                <div data-aos="fade-right" class="col-span-1 text-[16px]">
                    <a href="#">
                        <h4 class="text-xl font-bold text-[#00ccff]">Profil Singkat</h4>
                    </a>
                    <p>
                        Susunan kepengurusan koperasi Amanah Sejati Tahun 2021 adalah sebagai berikut :
                    </p>
                    <table class="table-struktur">
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td colspan="2">Pengurus Inti Koperasi</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Ketua</td>
                                <td>Candra Kesuma. ZA</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Sekretaris</td>
                                <td>Suharto, SP </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Bendahara</td>
                                <td>Nurul Komaraiah, S.Si, M.Si </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td colspan="2">Badan Pengawas</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Koordinator</td>
                                <td>Untung Idaman, HSB</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Anggota</td>
                                <td>Ampermi, SH</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Anggota</td>
                                <td>Soeroso, SH </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td colspan="2">Pembina</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Walikota Bengkulu</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Kepala Dinas Koperasi dan UKM Kota Bengkulu</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Ir. H. Syiful A. Yusuf</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="my-32">
                <div data-aos="fade-down" class="bg-white max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto text-[16px] leading-7  "
                    x-data="{selected:1}">
                    <ul class="shadow-box">

                        <li class="relative border-b border-gray-100">

                            <button type="button"
                                class="w-full   py-5 text-left border-b-[1px] text-lg font-bold hover:text-[#00ccff]  duration-300 transform border-gray-200"
                                x-bind:style="selected == 1 ? ' color:#00ccff' : ''"
                                @click="selected !== 1 ? selected = 1 : selected = null">
                                <div class="flex items-center justify-between">
                                    <span>
                                        Pendirian/Pembentukan Koperasi </span>
                                    <span class="ico-plus"></span>
                                </div>
                            </button>

                            <div class="relative overflow-hidden transition-all max-h-0 duration-700 bg-gray-100  "
                                x-ref="container1"
                                x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                <div class="p-6">
                                    <p>Pendirian/pembentukan koperasi dilaksanakan pada tanggal 28 Maret 2015.</p>
                                </div>
                            </div>

                        </li>


                        <li class="relative border-b border-gray-100">

                            <button type="button"
                                class="w-full   py-5 text-left border-b-[1px] text-lg font-bold hover:text-[#00ccff]  duration-300 transform"
                                x-bind:style="selected == 2 ? ' color:#00ccff' : ''"
                                @click="selected !== 2 ? selected = 2 : selected = null">
                                <div class="flex items-center justify-between">
                                    <span>
                                        Akta Pendirian
                                    </span>
                                    <span class="ico-plus"></span>
                                </div>
                            </button>

                            <div class="relative overflow-hidden transition-all max-h-0 duration-700 bg-gray-100  "
                                x-ref="container2"
                                x-bind:style="selected == 2 ? 'max-height: ' + $refs.container2.scrollHeight + 'px' : ''">
                                <div class="p-6">
                                    <p>Akta Pendirian Koperasi Nomor: 01/KPAS/2015 pada tanggal 6 April 2015, dikukuhkan
                                        dengan akta notaris Kuswari
                                        Ahmad, SH, M.Kn No.20 tanggal 13 April 2015 dan selanjutnya disahkan oleh Kepala
                                        Dinas Koperasi dan UKM Kota
                                        Bengkulu Nomor: 09/IX.4/2015 tanggal 15 April 2015.</p>
                                </div>
                            </div>

                        </li>


                        <li class="relative border-b border-gray-100">

                            <button type="button"
                                class="w-full   py-5 text-left border-b-[1px] text-lg font-bold hover:text-[#00ccff]  duration-300 transform"
                                x-bind:style="selected == 3 ? ' color:#00ccff' : ''"
                                @click="selected !== 3 ? selected = 3 : selected = null">
                                <div class="flex items-center justify-between">
                                    <span>
                                        Latar Belakang Pendirian </span>
                                    <span class="ico-plus"></span>
                                </div>
                            </button>

                            <div class="relative overflow-hidden transition-all max-h-0 duration-700 bg-gray-100  "
                                x-ref="container3"
                                x-bind:style="selected == 3 ? 'max-height: ' + $refs.container3.scrollHeight + 'px' : ''">
                                <div class="p-6">
                                    <p>Koperasi merupakan organisasi ekonomi kerakyatan yang berwatak sosial yang didirikan
                                        oleh para anggota

                                        dipimpin oleh para anggota dan dijalankan untuk meningkatkan kesejahteraan para
                                        anggota. Bertitik tolak dari
                                        pengertian “Dari, oleh dan untuk anggota”, maka suatu koperasi itu akan mencapai
                                        suatu kemajuan dan
                                        pengembangan yang wajar kalau koperasi tersebut benar-benar memperoleh dukungan
                                        peran serta aktif dan nyata
                                        dari para anggotanya, baik itu berupa peran serta didalam pemupukan modal sendiri
                                        oleh koperasi maupun peran
                                        serta anggota dalam mengambil keputusan-keputusan yang penting bagi kebahagiaan
                                        koperasi.

                                        Dengan demikian dapat disimpulkan bahwa anggota adalah pemilik sekaligus pelanggan
                                        dan pada hakekatnya
                                        pengolahan dan penanganan kegiatan haruslah berada ditangan para anggota sendiri
                                        yang kemudian didalam
                                        undang-undang No.12 tahun 1967 tentang Pokok-pokok Perkoperasian telah diatur
                                        sedemikian rupa sehingga
                                        mewujudkan bentuk mekanisme kerja dari pada alat-alat kelengkapan organisasi
                                        koperasi (BAB VIII Undang-undang
                                        No.12/1967)

                                        Berpedoman dari peran dan fungsi koperasi dalam hal kebersamaan dalam pemupukan
                                        modal usaha, maka kami dari
                                        Ketua P2MKP (Pusat Pelatihan Mandiri Kelautan dan Perikanan) Surabaya Makmur bersama
                                        para pembudidaya ikan dan
                                        keluarganya dengan semangat kebersamaan untuk mencapai tujuan khususnya untuk
                                        memperoleh modal usaha yang lebih
                                        cepat, mudah dan murah maka kami sepakat untuk membentuk koperasi.

                                        Berdasarkan musyawarah dalam pembentukan koperasi disepakati dari pihak anggota
                                        sebanyak 3 (tiga) orang
                                        bersedia meminjamkan uang untuk modal usaha koperasi sebesar Rp.100.000.000,-
                                        (seratus juta rupiah) tanpa bunga
                                        dan menghibahkan uang sebanyak Rp.5.000.000,- (lima juta rupiah) untuk biaya
                                        operasional kepengurusan pendirian
                                        koperasi, akte notaris, pembuatan papan nama, struktur organisasi, cap koperasi,
                                        buku administrasi dan
                                        keuangan, dll.

                                        Dengan telah disepakatinya pembentukan koperasi tersebut, maka pada tanggal 28 Maret
                                        2015 dilaksanakan
                                        sosialisasi pembentukan koperasi oleh pejabat dari Dinas Koperasi dan UKM Kota
                                        Bengkulu bertempat di
                                        sekretariat koperasi Jl.Tutwuri No.59 RT.04 RW.02 Kelurahan Surabaya Kecamatan
                                        Sungai Serut Kota Bengkulu
                                        bergabung dengan sekretariat P2MKP Surabaya Makmur</p>
                                </div>
                            </div>

                        </li>

                        <li class="relative border-b border-gray-100">

                            <button type="button"
                                class="w-full   py-5 text-left border-b-[1px] text-lg font-bold hover:text-[#00ccff]  duration-300 transform"
                                x-bind:style="selected == 4 ? ' color:#00ccff' : ''"
                                @click="selected !== 4 ? selected = 4 : selected = null">
                                <div class="flex items-center justify-between">
                                    <span>
                                        Maksud dan Tujuan
                                    </span>
                                    <span class="ico-plus"></span>
                                </div>
                            </button>

                            <div class="relative overflow-hidden transition-all max-h-0 duration-700 bg-gray-100  "
                                x-ref="container2"
                                x-bind:style="selected == 4 ? 'max-height: ' + $refs.container2.scrollHeight + 'px' : ''">
                                <div class="p-6">
                                    <ul class="list-disc ml-4">
                                        <li>
                                            <i class="fa fa-check text-success"></i> Mendirikan kelembagaan keuangan yang
                                            mudah diakses,
                                            murah bunga pinjaman, simpel dalam urusan administrasi dan terbuka dalam
                                            manajemen keuangan.
                                        </li>
                                        <li>
                                            <i class="fa fa-check text-success"></i> Menumbuh kembangkan rasa kebersamaan,
                                            rasa memiliki
                                            dan bertanggung jawab dalam kemajuan organisasi.
                                        </li>
                                        <li>
                                            <i class="fa fa-check text-success"></i> Membangun organisasi yang solid untuk
                                            kemajuan dan
                                            kesejahteraan anggota
                                        </li>
                                        <li>
                                            <i class="fa fa-check text-success"></i> Membangun organisasi yang solid untuk
                                            kemajuan dan
                                            kesejahteraan anggota
                                        </li>
                                        <li>
                                            <i class="fa fa-check text-success"></i> Menumbuh kembangkan sinergitas antara
                                            kelembagaan
                                            Pusat Pelatihan Mandiri Kelautan dan Perikanan (P2MKP) Surabaya Makmur sebagai
                                            sumber
                                            pengetahuan dan ketrampilan dengan Koperasi Produksi Amanah Sejati sebagai
                                            sumber
                                            keuangan/modal usaha untuk meningkatkan produktivitas dibidang perikanan
                                            budidaya.
                                        </li>
                                        <li>
                                            <i class="fa fa-check text-success"></i> Mendorong tumbuh kembangnya jiwa
                                            kewirausahaan dan
                                            kemandirian dalam usaha serta mendukung program pemerintah dengan mendekatkan
                                            sumber usaha
                                            serta sumber pengetahuan dan ketrampilan untuk menghasilkan produk yang optimal
                                            dan
                                            berkualitas.
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </li>

                    </ul>
                </div>
            </div>
            </div>


            <div class="bg-white" x-data="{ tab: 'visi' }">
                <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <section aria-labelledby="products-heading" class="pb-24 pt-6">

                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-5">

                            <div data-aos="fade-right" class="md:col-span-3">
                                <div class=" flex flex-wrap items-center   mt-4 text-sm sm:text-base whitespace-nowrap
                                cursor-base focus:outline-none border-b-2 border-gray-300 ">
                                    <a href="#" @click.prevent="tab = 'visi'"
                                        :class="{ 'bg-[#00ccff] text-white ' : tab === 'visi' }" class=" items-center py-2 bg-gray-100 rounded-tl-xl rounded-tr-xl   px-6
                        text-sm     sm:text-base
                        whitespace-nowrap cursor-base focus:outline-none ">
                                        Visi
                                    </a>

                                    <a href="#" @click.prevent="tab = 'misi'"
                                        :class="{ 'bg-[#00ccff] text-white ' : tab === 'misi' }"
                                        class=" items-center py-2 bg-gray-100 rounded-tl-xl rounded-tr-xl px-6     text-sm     sm:text-base   whitespace-nowrap cursor-base focus:outline-none ">
                                        Misi
                                    </a>

                                    <a href="#" @click.prevent="tab = 'tujuan'"
                                        :class="{ 'bg-[#00ccff] text-white ' : tab === 'tujuan' }"
                                        class=" items-center py-2 bg-gray-100 rounded-tl-xl rounded-tr-xl px-6     text-sm     sm:text-base   whitespace-nowrap cursor-base focus:outline-none ">
                                        Tujuan
                                    </a>

                                    <a href="#" @click.prevent="tab = 'kerjasaman'"
                                        :class="{ 'bg-[#00ccff] text-white ' : tab === 'kerjasaman' }"
                                        class=" items-center py-2 bg-gray-100 rounded-tl-xl rounded-tr-xl px-6     text-sm     sm:text-base   whitespace-nowrap cursor-base focus:outline-none ">
                                        Kerjasama
                                    </a>

                                </div>
                                <div class="mx-auto ">
                                    <article x-show="tab === 'visi'  " class="rounded-br-xl rounded-bl-xl bg-gray-100  duration-300 transform content-div
                                        p-7 group shadow-lg hover:shadow-xl">
                                        <h1 class="text-3xl font-bold text-[#0b3960]">VISI</h1>
                                        <p class="text-[16px] leading-7 mt-4">Menjadi Koperasi Produksi yang mampu
                                            memproduksi,
                                            menampung dan mempromosikan produk anggota ke wilayah Provinsi Bengkulu maupun
                                            ke Tingkat
                                            Nasional untuk meningkatkan kesejahteraan anggota secara demokratis.</p>

                                    </article>
                                    <article x-show="tab === 'misi'  " class="rounded-br-xl rounded-bl-xl bg-gray-100  duration-300 transform content-div
                                        p-7 group shadow-lg hover:shadow-xl">
                                        <h1 class="text-3xl font-bold text-[#0b3960]">MISI</h1>
                                        <ol class="list-decimal ml-4 text-[16px] leading-7 mt-4">
                                            <li>Menghasilkan produk pertanian dan perikanan yang berkualitas dan mampu
                                                bersaing di pasaran
                                                dari hasil produksi koperasi dan/atau anggota koperasi.</li>
                                            <li>Menyediakan peralatan dan bahan-bahan yang diperlukan/dibutuhkan oleh
                                                anggota koperasi untuk
                                                keperluan produksi.</li>
                                            <li>Menampung hasil produksi, melakukan penyempurnaan dan mempromosikan produk
                                                tersebut ke
                                                pasaran Tingkat Provinsi Bengkulu maupun Tingkat Nasional.</li>
                                            <li>Menampung hasil produksi, melakukan penyempurnaan dan mempromosikan produk
                                                tersebut ke
                                                pasaran Tingkat Provinsi Bengkulu maupun Tingkat Nasional.</li>
                                        </ol>

                                    </article>
                                    <article x-show="tab === 'tujuan'  " class="rounded-br-xl rounded-bl-xl bg-gray-100  duration-300 transform content-div
                                        p-7 group shadow-lg hover:shadow-xl">
                                        <h1 class="text-3xl font-bold text-[#0b3960]">TUJUAN</h1>
                                        <ol class="list-decimal text-[16px] leading-7 mt-4 ml-4">
                                            <li>Memberikan pinjaman modal kerja dengan jasa yang serendah-rendahnya dengan
                                                anggota agar
                                                dapat mengembangkan usahanya secara berkesinambungan.</li>
                                            <li>Memberikan alternatif produk konsumsi khususnya pertanian dan perikanan
                                                kepada masyarakat.
                                            </li>
                                            <li>Meningkatkan kesejahteraan anggota Koperasi Produksi Amanah Sejati.</li>
                                        </ol>

                                    </article>
                                    <article x-show="tab === 'kerjasaman'  " class="rounded-br-xl rounded-bl-xl bg-gray-100  duration-300 transform content-div
                                        p-7 group shadow-lg hover:shadow-xl">
                                        <h1 class="text-3xl font-bold text-[#0b3960]">KERJASAMA</h1>
                                        <table class="table text-[16px] leading-7 mt-4">
                                            <tbody>
                                                <tr class="border-b-2 border-gray-200">
                                                    <td>1.</td>
                                                    <td>KERJASAMA DENGAN PT. TASPEN BENGKULU</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Kerjasama dalam bentuk pemberian pinjaman penguatan modal usaha
                                                        koperasi yang
                                                        tertuang dalam Surat Perjanjian Modal Kerja antara PT. Taspen
                                                        (Perser) dengan Candra
                                                        Kesuma, ZA (Ketua Koperasi) Nomor: 011/102/2019 tanggal 09
                                                        September 2019.</td>
                                                </tr>

                                                <tr class="border-b-2 border-gray-200">
                                                    <td>2.</td>
                                                    <td>KERJASAMA DENGAN PEMERINTAH KOTA BENGKULUU</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        Kerjasama antara Pemerintah Kota Bengkulu melalui Dinas Koperasi
                                                        dan UKM Kota
                                                        Bengkulu dengan Koperasi Produksi Amanah Sejati dalam Program
                                                        Penguatan Pinjman
                                                        Modal Bergulir bagi Koperasi Berprestasi di Kota Bengkulu Tahun
                                                        2020 yang tertuang
                                                        dalam Surat Perjanjian Kerjasama Nomor: 518/289/D.KUKM/VIII/2020
                                                        dan Nomor:
                                                        40/KPAS/VIII/2020.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </article>
                                </div>
                            </div>
                            <div data-aos="fade-left" class="  md:col-span-2 border-gray-200 py-6">
                                <img src="{{ asset('assets/frontend/src/animate/undraw.svg') }}" class="mx-auto w-5/6 h-5/6">
                                <!-- Filter section, show/hide based on section state. -->

                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </section>
        <!-- end tentang  -->

        <!-- Footer  -->

        <footer class="relative bg-gradient-to-tl from-blue-900 overflow-hidden  to-cyan-600      ">
            <div class=" ">

                <div class="custom-shape-divider-top-1691310739">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="h-[150px]" viewBox="0 0 1200 120"
                        preserveAspectRatio="none">
                        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="fill-[#ffffff4c]"></path>
                    </svg>
                </div>
                <div class="custom-shape-divider-top-1691310739">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="h-[100px]" viewBox="0 0 1200 120"
                        preserveAspectRatio="none">
                        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="fill-[#ffffff84]"></path>
                    </svg>
                </div>
                <div class="custom-shape-divider-top-1691310739">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="h-[40px]" viewBox="0 0 1200 120"
                        preserveAspectRatio="none">
                        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="fill-[#ffffff4c]"></path>
                    </svg>
                </div>
                <div class="custom-shape-divider-top-1691310739">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="h-[20px]" viewBox="0 0 1200 120"
                        preserveAspectRatio="none">
                        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="fill-[#fffffff1]"></path>
                    </svg>
                </div>



            </div>

            <div class=" mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 pt-36 pb-16   flex md:items-center lg:items-start
                md:flex-row md:flex-nowrap flex-wrap flex-col">
                <div class="lg:w-2/4 md:w-1/2 w-full flex-shrink-0 md:mx-0 mx-auto text-center md:text-left">
                    <a href="/view/home.html" class="flex items-center text-black      ">
                        <img src="{{ asset('assets/img/logo.png') }}" class="md:w-14 md:h-14 w-12 h-12">

                        <div class="ml-3 text-white   ">
                            <strong class=" text-2xl md:text-3xl font-extrabold  tracking-wider uppercase">KOPERASI</strong>
                            <p class="text-[13px] md:text-[18px] text-gray-300 tracking-widest font-semibold  uppercase -mt-2
                                    relative">
                                Amanah Sejati</p>
                        </div>
                    </a>
                    <p class="  mt-4 text-sm text-gray-200 leading-6">Menjadi Koperasi Produksi yang mampu memproduksi,
                        menampung dan mempromosikan produk anggota ke wilayah Provinsi Bengkulu maupun ke Tingkat Nasional
                        untuk meningkatkan kesejahteraan anggota secara demokratis
                    </p>
                    <a class="flex  my-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="fill-gray-200 group-hover:fill-yellow-300 w-5 h-5 mr-3" viewBox="0 0 16 16" id="map">
                            <path
                                d="M8 0C5.2 0 3 2.2 3 5s4 11 5 11 5-8.2 5-11-2.2-5-5-5zm0 8C6.3 8 5 6.7 5 5s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z">
                            </path>
                        </svg>


                        <span class=" text-sm text-gray-200 group-hover:text-yellow-300  duration-300 transform
                            break-normal">Surabaya, Bengkulu</span>
                    </a>

                    <a class="flex  my-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="fill-gray-200 group-hover:fill-yellow-300 w-5 h-5 mr-3 " fill="currentColor"
                            class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                        </svg>

                        <span
                            class="  text-sm text-gray-200 group-hover:text-yellow-300  duration-300 transform break-normal">08080808080808</span>
                    </a>

                    <a class="flex  my-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="fill-gray-200 group-hover:fill-yellow-300 w-5 h-5 mr-3  " fill="currentColor"
                            class="bi bi-envelope" viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                        </svg>
                        <span class=" text-sm text-gray-200 group-hover:text-yellow-300  duration-300 transform
                                break-normal">koperasiproduksiamanahsejati@gmail.com</span>
                    </a>
                </div>

                <div class="lg:w-2/4 md:w-1/2 w-full px-4 md:ml-6">
                    <h2 class="title-font text-2xl  mt-6   text-white font-bold    mb-3">
                        Informasi
                    </h2>
                    <p class="  mt-4 text-sm text-white leading-6">Pendirian/pembentukan koperasi dilaksanakan pada
                        tanggal
                        28 Maret 2015

                    </p>
                    <iframe class="shadow-[0px_0px_10px_0px_#444] mt-3 rounded-md w-full h-[250px]"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1990.5449321891977!2d102.314648!3d-3.790609!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e36b106aa288fb3%3A0x351027949545a86a!2sKota%20Bengkulu%2C%20Bengkulu%2038119!5e0!3m2!1sid!2sid!4v1691316506181!5m2!1sid!2sid"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="px-12 mx-auto py-4   flex flex-wrap flex-col sm:flex-row bg-gray-100  ">
                <p class="text-gray-700  text-sm text-center sm:text-left">Copyright&copy; 2023 |
                    <a href="#" class="text-yellow-500 font-bold">Koperasi Amanah Sejati</a>. All rights reserved.
                </p>
            </div>
        </footer>
        <!-- end Footer -->
        <!-- back to top  -->
        <div class="" x-data="{scrollBackTop: false}" x-cloak>
            <svg x-show="scrollBackTop" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                x-on:scroll.window="scrollBackTop = (window.pageYOffset > window.outerHeight * 0.5) ? true : false"
                aria-label="Back to top" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                class="bi bi-arrow-up-circle-fill fixed bottom-0 right-0 mx-3 my-10   w-8 dark:fill-blue-700 fill-blue-500 shadow-lg    cursor-pointer hover:fill-blue-400 bg-white       rounded-full "
                viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
            </svg>
        </div>

    </body>

    <!-- script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('assets/frontend/scripts.js') }}"></script>
    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/055120b175.js" crossorigin="anonymous"></script>
</html>
