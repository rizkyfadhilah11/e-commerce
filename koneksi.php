<?php
    $conn = mysqli_connect("localhost", "root", "", "db_gummo");
    if(mysqli_connect_errno()){
        echo mysqli_connect_error();
    }
    


    function tambah($data){
        global $conn;

        $kategori = htmlspecialchars($data["id_kategori"]) ;
        $nama = htmlspecialchars($data["nama_produk"]);
        $harga = htmlspecialchars($data["harga"]);
        $quantity = htmlspecialchars($data["quantity"]);
        $deskripsi = htmlspecialchars($data["deskripsi"]);
        

        $gambar = upload();
        if(!$gambar){
            return false;
        }

        $query = "INSERT INTO produk VALUES
        ('', '$kategori','$nama', '$harga', '$quantity', '$gambar', '$deskripsi') ";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function upload(){
        $namafile = $_FILES['gambar']['name'];
        $ukuranfile = $_FILES ['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpname = $_FILES['gambar']['tmp_name'];

        //cek ada gambar yang diupload apa tidak
        if($error === 4) {
            echo "<script>
                alert('pilih gambar terlebih dahulu!');
            </script>" ;

            return false;
        }

        //cek apakah yg diupload itu gambar
        $ekstensigambarvalid = ['jpg', 'jpeg', 'png'];
        $ekstensigambar = explode('.', $namafile);
        $ekstensigambar = strtolower(end($ekstensigambar));
        if(!in_array($ekstensigambar, $ekstensigambarvalid)){
            echo "<script>
                alert('yang diupload bukan gambar!');
            </script>" ;
            return false;
        }

        //cek ukuran gambar
        if($ukuranfile > 1000000){
            echo "<script>
                alert('ukuran gambar terlalu besar!');
            </script>" ;
            return false;
        }

        //lolos siap upload
        //generate nama baru
        $namabaru = uniqid();
        $namabaru .= '.';
        $namabaru .= $ekstensigambar ;
        
        move_uploaded_file($tmpname, '../../image/'.$namabaru);
        return $namabaru;
        
        }

    



    function hapus($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM produk WHERE id = $id");

        return mysqli_affected_rows($conn);
    }




    function ubah ($u){
        global $conn;

        $id = $u["id"];
        $kategori = htmlspecialchars($u["id_kategori"]) ;
        $nama = htmlspecialchars($u["nama_produk"]);
        $harga = htmlspecialchars($u["harga"]);
        $quantity = htmlspecialchars($u["quantity"]);      
        $deskripsi = htmlspecialchars($u["deskripsi"]);      
        $gambarlama = htmlspecialchars($u["gambarlama"]);

        //cek user pilih gambar baru atau tidak
        if($_FILES['gambar']['error'] === 4){
            $gambar = $gambarlama ;
        }else{
            $gambar = upload();
        }

        $query = "UPDATE produk SET 
                    id_kategori = '$kategori',
                    nama_produk = '$nama',
                    harga = '$harga',
                    quantity = '$quantity',
                    gambar = '$gambar',
                    deskripsi = '$deskripsi'
                    WHERE id = $id
                    ";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }


    function kategori($k){
        global $conn;

        $nama = htmlspecialchars($k["nama_kategori"]);

        $query = "INSERT INTO kategori VALUES
        ('', '$nama')";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function editkategori($e){
        global $conn;

        $id = $e["id_kategori"];
        $nama = htmlspecialchars($e["nama_kategori"]);

        $query = "UPDATE kategori SET nama_kategori = '$nama' WHERE id_kategori = $id";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }
    
    function delete($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = $id");

        return mysqli_affected_rows($conn);
    }



    function metode($m){
        global $conn;

        $metode = htmlspecialchars($m["metode"]);
        $norek = htmlspecialchars($m["norek"]);
        $an = htmlspecialchars($m["atas_nama"]);
        
        $logo = unggah();
        if(!$logo){
            return false;
        }

        $query = "INSERT INTO pembayaran VALUES
        ('', '$metode', '$norek', '$an', '$logo')";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);

    }

    function unggah(){
        $namafile = $_FILES['logo']['name'];
        $ukuranfile = $_FILES ['logo']['size'];
        $error = $_FILES['logo']['error'];
        $tmpname = $_FILES['logo']['tmp_name'];

         //cek ada gambar yang diupload apa tidak
         if($error === 4) {
            echo "<script>
                alert('pilih gambar terlebih dahulu!');
            </script>" ;

            return false;
        }
        //cek apakah yg diupload itu gambar
        $ekstensigambarvalid = ['jpg', 'jpeg', 'png'];
        $ekstensigambar = explode('.', $namafile);
        $ekstensigambar = strtolower(end($ekstensigambar));
        if(!in_array($ekstensigambar, $ekstensigambarvalid)){
            echo "<script>
                alert('yang diupload bukan gambar!');
            </script>" ;
            return false;
        }

        //cek ukuran gambar
        if($ukuranfile > 1000000){
            echo "<script>
                alert('ukuran gambar terlalu besar!');
            </script>" ;
            return false;
        }

        //lolos siap upload
        //generate nama baru
        $namabaru = uniqid();
        $namabaru .= '.';
        $namabaru .= $ekstensigambar ;
        
        move_uploaded_file($tmpname, '../../image/'.$namabaru);
        return $namabaru;
        
        
    }


    function del($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM pembayaran WHERE id = $id");

        return mysqli_affected_rows($conn);
    }


    function editpembayaran($edit){
        global $conn;

        $id = $edit["id"];
        $metode = htmlspecialchars($edit["metode"]);
        $norek = htmlspecialchars($edit["norek"]);
        $an = htmlspecialchars($edit["atas_nama"]);
        $logolama = htmlspecialchars($edit["logolama"]);

        //cek user pilih gambar baru atau tidak
        if($_FILES['logo']['error'] === 4){
            $logo = $logolama ;
        }else{
            $logo = unggah();
        }

        $queryedit = "UPDATE pembayaran SET
                    metode = '$metode', 
                    norek = '$norek', 
                    atas_nama = '$an', 
                    logo = '$logo'
                    WHERE id = $id ";
                
        mysqli_query($conn, $queryedit);

        return mysqli_affected_rows($conn);
    }

    function registrasi($data){
        global $conn;

        $nama = stripslashes($data["nama"]);
        $username = strtolower(stripslashes($data["username"]));
        $email = $data["email"];
        $nohp = $data["notelp"];
        $password = mysqli_escape_string($conn, $data["password"]);
        $password2 = mysqli_escape_string($conn, $data["password2"]);

        //cek username sama
        $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
        if(mysqli_fetch_assoc ($result)){
            echo "<script>
                    alert ('Username sudah ada!');
                    </script>";
                return false;
        }
        // cek email
        $result2 = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
        if(mysqli_fetch_assoc ($result2)){
            echo "<script>
                    alert ('Email Sudah Terdaftar, Silahkan Login!');
                    </script>";
                return false;
        }

        // cek no hp
        $result3 = mysqli_query($conn, "SELECT * FROM user WHERE no_hp = '$nohp'");
        if(mysqli_fetch_assoc ($result3)){
            echo "<script>
                    alert ('Nomor Telepon Sudah Terdaftar !');
                    </script>";
                return false;
        }

        //cek password
        if($password !== $password2){
            echo "<script>
                    alert ('Konfirmasi password salah!');
                </script>";

                return false;
        }

        //enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn, "INSERT INTO user VALUES('', '$nama', '$username', '$email', '$nohp',  '$password')");

        return mysqli_affected_rows($conn);
    }

    function register($data){
        global $conn;

        $nama = stripslashes($data["nama"]);
        $username = strtolower(stripslashes($data["username"]));
        $email = $data["email"];
        $password = mysqli_escape_string($conn, $data["password"]);
        $password2 = mysqli_escape_string($conn, $data["password2"]);

        //cek username sama
        $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
        if(mysqli_fetch_assoc ($result)){
            echo "<script>
                    alert ('Username sudah ada!');
                    </script>";
                return false;
        }

        

        //cek password
        if($password !== $password2){
            echo "<script>
                    alert ('Konfirmasi password salah!');
                </script>";

                return false;
        }

        //enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn, "INSERT INTO admin VALUES('', '$nama', '$username', '$email', '$password')");

        return mysqli_affected_rows($conn);
    }

    function hap($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM user WHERE id = $id");

        return mysqli_affected_rows($conn);
    
    }

  
?>