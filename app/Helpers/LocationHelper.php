<?php

namespace App\Helpers;

class LocationHelper
{
    /**
     * Get all 64 districts and their thanas in Bangladesh.
     *
     * @return array
     */
    public static function getDistrictsAndThanas(): array
    {
        return [
            'Dhaka' => [
                'Badda', 'Banani', 'Bangshal', 'Cantonment', 'Chawkbazar', 'Darus Salam', 'Demra', 
                'Dhanmondi', 'Gendaria', 'Gulshan', 'Hazaribagh', 'Jatrabari', 'Kadamtali', 'Kafrul', 
                'Kalabagan', 'Kamrangirchar', 'Khilgaon', 'Khilkhet', 'Lalbagh', 'Mirpur', 'Mohammadpur', 
                'Motijheel', 'New Market', 'Pallabi', 'Paltan', 'Ramna', 'Rampura', 'Sabujbagh', 
                'Shah Ali', 'Shahbagh', 'Sher-e-Bangla Nagar', 'Shyampur', 'Sutrapur', 'Tejgaon', 
                'Tejgaon Industrial Area', 'Turag', 'Uttara Bank', 'Uttara East', 'Uttara West', 
                'Vatara', 'Wari', 'Dhamrai', 'Dohar', 'Keraniganj', 'Nawabganj', 'Savar'
            ],
            'Chattogram' => [
                'Anwara', 'Banshkhali', 'Boalkhali', 'Chandanaish', 'Double Mooring', 'Fatikchhari', 
                'Hathazari', 'Lohagara', 'Mirsharai', 'Patiya', 'Rangunia', 'Raozan', 'Sandwip', 
                'Satkania', 'Sitakunda', 'Kotwali', 'Panchlaish', 'Chandgaon', 'Halishahar', 
                'Patenga', 'Bayazid', 'Khulshi', 'Akbar Shah', 'Karnaphuli'
            ],
            'Gazipur' => [
                'Gazipur Sadar', 'Kaliakair', 'Kaliganj', 'Kapasia', 'Sreepur', 'Tongi East', 'Tongi West'
            ],
            'Narayanganj' => [
                'Araihazar', 'Bandar', 'Narayanganj Sadar', 'Rupganj', 'Sonargaon'
            ],
            'Narsingdi' => [
                'Narsingdi Sadar', 'Belabo', 'Monohardi', 'Palash', 'Raipura', 'Shibpur'
            ],
            'Madaripur' => [
                'Madaripur Sadar', 'Kalkini', 'Rajoir', 'Shibchar'
            ],
            'Gopalganj' => [
                'Gopalganj Sadar', 'Kashiani', 'Kotalipara', 'Muksudpur', 'Tungipara'
            ],
            'Faridpur' => [
                'Faridpur Sadar', 'Alfadanga', 'Bhanga', 'Boalmari', 'Charbhadrasan', 'Madhukhali', 
                'Nagarkanda', 'Sadarpur', 'Saltha'
            ],
            'Munshiganj' => [
                'Munshiganj Sadar', 'Gazaria', 'Lohajang', 'Sirajdikhan', 'Sreenagar', 'Tongibari'
            ],
            'Natore' => [
                'Natore Sadar', 'Bagatipara', 'Baraigram', 'Gurudaspur', 'Lalpur', 'Singra', 'Naldanga'
            ],
            'Rajshahi' => [
                'Rajshahi Sadar', 'Bagha', 'Bagmara', 'Charghat', 'Durgapur', 'Godagari', 'Mohanpur', 
                'Puthia', 'Tanore', 'Paba'
            ],
            'Bogura' => [
                'Bogura Sadar', 'Adamdighi', 'Dhunat', 'Dhupchanchia', 'Gabtali', 'Kahaloo', 
                'Nandigram', 'Sariakandi', 'Sherpur', 'Shibganj', 'Sonatola', 'Shajahanpur'
            ],
            'Joypurhat' => [
                'Joypurhat Sadar', 'Akkelpur', 'Kalai', 'Khetlal', 'Panchbibi'
            ],
            'Naogaon' => [
                'Naogaon Sadar', 'Atrai', 'Badalgachhi', 'Dhamoirhat', 'Manda', 'Mahadebpur', 
                'Niamatpur', 'Patnitala', 'Porsha', 'Raninagar', 'Sapahar'
            ],
            'Pabna' => [
                'Pabna Sadar', 'Atgharia', 'Bera', 'Bhangura', 'Chatmohar', 'Faridpur', 
                'Ishwardi', 'Santhia', 'Sujanagar'
            ],
            'Sirajganj' => [
                'Sirajganj Sadar', 'Belkuchi', 'Chauhali', 'Kamarkhanda', 'Kazipur', 'Rayganj', 
                'Shahjadpur', 'Tarash', 'Ullahpara'
            ],
            'Chapainawabganj' => [
                'Chapainawabganj Sadar', 'Bholahat', 'Gomastapur', 'Nachole', 'Shibganj'
            ],
            'Sylhet' => [
                'Sylhet Sadar', 'Balaganj', 'Beanibazar', 'Bishwanath', 'Companiganj', 'Fenchuganj', 
                'Golapganj', 'Gowainghat', 'Jaintiapur', 'Kanaighat', 'Zakiganj', 'South Surma', 'Osmani Nagar'
            ],
            'Moulvibazar' => [
                'Moulvibazar Sadar', 'Barlekha', 'Kamalganj', 'Kulaura', 'Rajnagar', 'Sreemangal', 'Juri'
            ],
            'Habiganj' => [
                'Habiganj Sadar', 'Ajmiriganj', 'Bahubal', 'Baniyachong', 'Chunarughat', 'Lakshai', 
                'Madhabpur', 'Nabiganj', 'Sayestaganj'
            ],
            'Sunamganj' => [
                'Sunamganj Sadar', 'Bishwamandarpur', 'Chhatak', 'Derai', 'Dharamapasha', 'Dowarabazar', 
                'Jagannathpur', 'Jamalganj', 'Sullah', 'Tahirpur', 'South Sunamganj'
            ],
            'Khulna' => [
                'Khulna Sadar', 'Batiaghata', 'Dacope', 'Dumuria', 'Dighalia', 'Koyra', 'Paikgachha', 
                'Phultala', 'Rupsha', 'Terokhada', 'Khalishpur', 'Daulatpur', 'Sonadanga', 'Khan Jahan Ali'
            ],
            'Bagerhat' => [
                'Bagerhat Sadar', 'Chitalmari', 'Fakirhat', 'Kachua', 'Mollahat', 'Mongla', 
                'Morrelganj', 'Rampal', 'Sarankhola'
            ],
            'Satkhira' => [
                'Satkhira Sadar', 'Assasuni', 'Debhata', 'Kalaroa', 'Kaliganj', 'Shyamnagar', 'Tala'
            ],
            'Jashore' => [
                'Jashore Sadar', 'Abhaynagar', 'Bagherpara', 'Chougachha', 'Jhikargachha', 'Keshabpur', 
                'Manirampur', 'Sharsha'
            ],
            'Magura' => [
                'Magura Sadar', 'Mohammadpur', 'Shalikha', 'Sreepur'
            ],
            'Narail' => [
                'Narail Sadar', 'Kalia', 'Lohagara'
            ],
            'Kushtia' => [
                'Kushtia Sadar', 'Bheramara', 'Daulatpur', 'Khoksa', 'Kumarkhali', 'Mirpur'
            ],
            'Chuadanga' => [
                'Chuadanga Sadar', 'Alamdanga', 'Damurhuda', 'Jibannagar'
            ],
            'Meherpur' => [
                'Meherpur Sadar', 'Gangni', 'Mujibnagar'
            ],
            'Jhenaidah' => [
                'Jhenaidah Sadar', 'Harakunda', 'Kaliganj', 'Kotchandpur', 'Maheshpur', 'Shailkupa'
            ],
            'Barishal' => [
                'Barishal Sadar', 'Bakerganj', 'Babuganj', 'Banaripara', 'Gaurnadi', 'Hizla', 
                'Mehendiganj', 'Muladi', 'Wazirpur'
            ],
            'Bhola' => [
                'Bhola Sadar', 'Burhanuddin', 'Char Fasson', 'Daulatkhan', 'Lalmohan', 'Manpura', 'Tazumuddin'
            ],
            'Patuakhali' => [
                'Patuakhali Sadar', 'Bauphal', 'Dashmina', 'Galachipa', 'Kalapara', 'Mirzaganj', 
                'Dumki', 'Rangabali'
            ],
            'Pirojpur' => [
                'Pirojpur Sadar', 'Bhandaria', 'Kawkhali', 'Mathbaria', 'Nazirpur', 'Nesarabad (Swarupkati)', 'Zianagar'
            ],
            'Jhalokathi' => [
                'Jhalokathi Sadar', 'Kathalia', 'Nalchity', 'Rajapur'
            ],
            'Barguna' => [
                'Barguna Sadar', 'Amtali', 'Bamna', 'Betagi', 'Patharghata', 'Taltali'
            ],
            'Rangpur' => [
                'Rangpur Sadar', 'Badarganj', 'Gangachara', 'Kaunia', 'Mithapukur', 'Pirgachha', 
                'Pirganj', 'Taraganj'
            ],
            'Dinajpur' => [
                'Dinajpur Sadar', 'Biral', 'Birampur', 'Birganj', 'Bochaganj', 'Chirirbandar', 
                'Phulbari', 'Ghoraghat', 'Hakimpur', 'Kaharole', 'Khansama', 'Nawabganj', 'Parbatipur'
            ],
            'Kurigram' => [
                'Kurigram Sadar', 'Bhurungamari', 'Char Rajibpur', 'Chilmari', 'Phulbari', 
                'Rajarhat', 'Rowmari', 'Nageshwari', 'Ulipur'
            ],
            'Gaibandha' => [
                'Gaibandha Sadar', 'Phulchhari', 'Gobindaganj', 'Palashbari', 'Sadullapur', 
                'Saghata', 'Sundarganj'
            ],
            'Lalmonirhat' => [
                'Lalmonirhat Sadar', 'Aditmari', 'Hatibandha', 'Kaliganj', 'Patgram'
            ],
            'Nilphamari' => [
                'Nilphamari Sadar', 'Dimla', 'Domar', 'Jaldhaka', 'Kishoreganj', 'Saidpur'
            ],
            'Panchagarh' => [
                'Panchagarh Sadar', 'Atwari', 'Boda', 'Debiganj', 'Tetulia'
            ],
            'Thakurgaon' => [
                'Thakurgaon Sadar', 'Baliadangi', 'Haripur', 'Ranisankail', 'Pirganj'
            ],
            'Mymensingh' => [
                'Mymensingh Sadar', 'Bhaluka', 'Dhobaura', 'Fulbaria', 'Gaffargaon', 'Gauripur', 
                'Haluaghat', 'Ishwarganj', 'Muktagachha', 'Nandail', 'Phulpur', 'Trishal', 'Tarafund'
            ],
            'Netrokona' => [
                'Netrokona Sadar', 'Atpara', 'Barhatta', 'Durgapur', 'Khaliajuri', 'Kalmakanda', 
                'Kendua', 'Madan', 'Mohanganj', 'Purbadhala'
            ],
            'Sherpur' => [
                'Sherpur Sadar', 'Jhenaigati', 'Nakla', 'Nalitabari', 'Sreebardi'
            ],
            'Jamalpur' => [
                'Jamalpur Sadar', 'Baksiganj', 'Dewanganj', 'Isampur', 'Melandaha', 'Sarishabari', 'Madarganj'
            ],
            'Tangail' => [
                'Tangail Sadar', 'Basail', 'Bhuapur', 'Delduar', 'Ghatail', 'Gopalpur', 
                'Kalihati', 'Madhupur', 'Mirzapur', 'Nagarpur', 'Sakhipur', 'Dhanbari'
            ],
            'Kishoreganj' => [
                'Kishoreganj Sadar', 'Astagram', 'Bajitpur', 'Bhairab', 'Hossainpur', 'Itna', 
                'Karimaganj', 'Katiadi', 'Kuliarchar', 'Mithamain', 'Nikli', 'Pakundia', 'Tarail'
            ],
            'Manikganj' => [
                'Manikganj Sadar', 'Singair', 'Shibalaya', 'Saturia', 'Harirampur', 'Gheor', 'Daulatpur'
            ],
            'Shariatpur' => [
                'Shariatpur Sadar', 'Damudya', 'Gosairhat', 'Naria', 'Bhedarganj', 'Zajira'
            ],
            'Rajbari' => [
                'Rajbari Sadar', 'Baliakandi', 'Goalandaghat', 'Pangsha', 'Kalukhali'
            ],
            'Cumilla' => [
                'Cumilla Sadar', 'Barura', 'Brahmanpara', 'Burichang', 'Chandina', 'Chauddagram', 
                'Daudkandi', 'Debidwar', 'Homna', 'Laksam', 'Muradnagar', 'Nangalkot', 'Meghna', 
                'Titas', 'Monohorganj', 'Sadarsouth'
            ],
            'Brahmanbaria' => [
                'Brahmanbaria Sadar', 'Ashuganj', 'Bancharampur', 'Kasba', 'Nabinagar', 
                'Nasirnagar', 'Sarail', 'Akhaura', 'Bijoynagar'
            ],
            'Chandpur' => [
                'Chandpur Sadar', 'Faridganj', 'Haimchar', 'Haziganj', 'Kachua', 'Matlabnorth', 
                'Matlabsouth', 'Shahrasti'
            ],
            'Lakshmipur' => [
                'Lakshmipur Sadar', 'Raipur', 'Ramganj', 'Ramgati', 'Kamalnagar'
            ],
            'Noakhali' => [
                'Noakhali Sadar', 'Begumganj', 'Chatkhil', 'Companiganj', 'Hatiya', 'Senbagh', 
                'Subarnachar', 'Sonaimuri', 'Kabirhat'
            ],
            'Feni' => [
                'Feni Sadar', 'Chhagalnaiya', 'Daganbhuiyan', 'Parshuram', 'Sonavazi', 'Fulgazi'
            ],
            'Khagrachhari' => [
                'Khagrachhari Sadar', 'Dighinala', 'Lakshmichhari', 'Mahalchhari', 'Manikchhari', 
                'Matiranga', 'Panchhari', 'Ramgarh'
            ],
            'Rangamati' => [
                'Rangamati Sadar', 'Bagaichhari', 'Barkal', 'Kawkhali', 'Belaichhari', 
                'Kaptai', 'Juraichhari', 'Langadu', 'Naniarchar', 'Rajasthali'
            ],
            'Bandarban' => [
                'Bandarban Sadar', 'Alikadam', 'Gudu', 'Naikhongchhari', 'Rowangchhari', 
                'Ruma', 'Thanchi'
            ],
        ];
    }
}
