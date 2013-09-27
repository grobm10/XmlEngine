<?php
/**  
 * @author 		David Curras
 * @version		June 6, 2012
 */
 
die('Comment this line to use the SqlInsertToXml.php file');

require_once '../../siteConfig.php';
require_once '../../Utils/Bootstrap.php';
Bootstrap::SetRequiredFiles();

$sqlInserts = array("INSERT INTO `concurrency_tbl` (`concurrency_id`, `video_id`, `videofile_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8);",
"INSERT INTO `outputfile_tbl` (`outputfile_id`, `videofile_id`, `video_encoded_name`, `video_encoded_location`, `output_width`, `output_height`, `bitrate`, `media_type`, `video_encoded`, `video_uploaded`) VALUES
(1, 1, 'DENW21200047_384x216_150_b30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/denw21/200047/DENW21200047_384x216_150_b30.mp4', 384, 216, '150', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(2, 1, 'DENW21200047_384x216_400_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/denw21/200047/DENW21200047_384x216_400_m30.mp4', 384, 216, '400', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(3, 1, 'DENW21200047_448x252_450_b30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/denw21/200047/DENW21200047_448x252_450_b30.mp4', 448, 252, '450', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(4, 1, 'DENW21200047_512x288_750_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/denw21/200047/DENW21200047_512x288_750_m30.mp4', 512, 288, '750', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(5, 1, 'DENW21200047_640x360_1200_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/denw21/200047/DENW21200047_640x360_1200_m30.mp4', 640, 360, '1200', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(6, 1, 'DENW21200047_768x432_1700_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/denw21/200047/DENW21200047_768x432_1700_m30.mp4', 768, 432, '1700', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(7, 2, 'FRUV71200155_384x216_150_b30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/fruv71/200155/FRUV71200155_384x216_150_b30.mp4', 384, 216, '150', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(8, 2, 'FRUV71200155_384x216_400_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/fruv71/200155/FRUV71200155_384x216_400_m30.mp4', 384, 216, '400', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(9, 2, 'FRUV71200155_448x252_450_b30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/fruv71/200155/FRUV71200155_448x252_450_b30.mp4', 448, 252, '450', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(10, 2, 'FRUV71200155_512x288_750_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/fruv71/200155/FRUV71200155_512x288_750_m30.mp4', 512, 288, '750', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(11, 2, 'FRUV71200155_640x360_1200_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/fruv71/200155/FRUV71200155_640x360_1200_m30.mp4', 640, 360, '1200', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(12, 2, 'FRUV71200155_768x432_1700_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/fruv71/200155/FRUV71200155_768x432_1700_m30.mp4', 768, 432, '1700', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(13, 3, 'USGQ41000005_384x288_170_b30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usgq41/000005/USGQ41000005_384x288_170_b30.mp4', 384, 288, '170', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(14, 3, 'USGQ41000005_384x288_400_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usgq41/000005/USGQ41000005_384x288_400_m30.mp4', 384, 288, '400', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(15, 3, 'USGQ41000005_400x300_450_b30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usgq41/000005/USGQ41000005_400x300_450_b30.mp4', 400, 300, '450', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(16, 3, 'USGQ41000005_448x336_600_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usgq41/000005/USGQ41000005_448x336_600_m30.mp4', 448, 336, '600', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(17, 3, 'USGQ41000005_480x360_900_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usgq41/000005/USGQ41000005_480x360_900_m30.mp4', 480, 360, '900', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(18, 3, 'USGQ41000005_576x432_1200_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usgq41/000005/USGQ41000005_576x432_1200_m30.mp4', 576, 432, '1200', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(19, 3, 'USGQ41000005_640x480_1600_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usgq41/000005/USGQ41000005_640x480_1600_m30.mp4', 640, 480, '1600', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(20, 4, 'BRWFM0900072_384x216_150_b30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/brwfm0/900072/BRWFM0900072_384x216_150_b30.mp4', 384, 216, '150', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(21, 4, 'BRWFM0900072_384x216_400_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/brwfm0/900072/BRWFM0900072_384x216_400_m30.mp4', 384, 216, '400', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(22, 4, 'BRWFM0900072_448x252_450_b30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/brwfm0/900072/BRWFM0900072_448x252_450_b30.mp4', 448, 252, '450', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(23, 4, 'BRWFM0900072_512x288_750_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/brwfm0/900072/BRWFM0900072_512x288_750_m30.mp4', 512, 288, '750', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(24, 4, 'BRWFM0900072_640x360_1200_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/brwfm0/900072/BRWFM0900072_640x360_1200_m30.mp4', 640, 360, '1200', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(25, 4, 'BRWFM0900072_768x432_1700_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/brwfm0/900072/BRWFM0900072_768x432_1700_m30.mp4', 768, 432, '1700', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(26, 5, 'HKUV71200030_384x216_150_b30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/hkuv71/200030/HKUV71200030_384x216_150_b30.mp4', 384, 216, '150', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(27, 5, 'HKUV71200030_384x216_400_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/hkuv71/200030/HKUV71200030_384x216_400_m30.mp4', 384, 216, '400', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(28, 5, 'HKUV71200030_448x252_450_b30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/hkuv71/200030/HKUV71200030_448x252_450_b30.mp4', 448, 252, '450', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(29, 5, 'HKUV71200030_512x288_750_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/hkuv71/200030/HKUV71200030_512x288_750_m30.mp4', 512, 288, '750', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(30, 5, 'HKUV71200030_640x360_1200_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/hkuv71/200030/HKUV71200030_640x360_1200_m30.mp4', 640, 360, '1200', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(31, 5, 'HKUV71200030_768x432_1700_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/hkuv71/200030/HKUV71200030_768x432_1700_m30.mp4', 768, 432, '1700', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(32, 6, 'CZUV71200033_384x216_150_b30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/czuv71/200033/CZUV71200033_384x216_150_b30.mp4', 384, 216, '150', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(33, 6, 'CZUV71200033_384x216_400_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/czuv71/200033/CZUV71200033_384x216_400_m30.mp4', 384, 216, '400', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(34, 6, 'CZUV71200033_448x252_450_b30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/czuv71/200033/CZUV71200033_448x252_450_b30.mp4', 448, 252, '450', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(35, 6, 'CZUV71200033_512x288_750_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/czuv71/200033/CZUV71200033_512x288_750_m30.mp4', 512, 288, '750', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(36, 6, 'CZUV71200033_640x360_1200_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/czuv71/200033/CZUV71200033_640x360_1200_m30.mp4', 640, 360, '1200', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(37, 6, 'CZUV71200033_768x432_1700_m30.mp4', '/8619/_!/intlod/MTVInternational/umg_int/czuv71/200033/CZUV71200033_768x432_1700_m30.mp4', 768, 432, '1700', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(38, 7, 'USSE91232801_384x288_170_b30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usse91/232801/USSE91232801_384x288_170_b30.mp4', 384, 288, '170', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(39, 7, 'USSE91232801_384x288_400_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usse91/232801/USSE91232801_384x288_400_m30.mp4', 384, 288, '400', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(40, 7, 'USSE91232801_400x300_450_b30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usse91/232801/USSE91232801_400x300_450_b30.mp4', 400, 300, '450', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(41, 7, 'USSE91232801_448x336_600_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usse91/232801/USSE91232801_448x336_600_m30.mp4', 448, 336, '600', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(42, 7, 'USSE91232801_480x360_900_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usse91/232801/USSE91232801_480x360_900_m30.mp4', 480, 360, '900', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(43, 7, 'USSE91232801_576x432_1200_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usse91/232801/USSE91232801_576x432_1200_m30.mp4', 576, 432, '1200', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(44, 7, 'USSE91232801_640x480_1600_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/usse91/232801/USSE91232801_640x480_1600_m30.mp4', 640, 480, '1600', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(45, 8, 'GB1101200428_384x288_170_b30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/gb1101/200428/GB1101200428_384x288_170_b30.mp4', 384, 288, '170', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(46, 8, 'GB1101200428_384x288_400_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/gb1101/200428/GB1101200428_384x288_400_m30.mp4', 384, 288, '400', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(47, 8, 'GB1101200428_400x300_450_b30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/gb1101/200428/GB1101200428_400x300_450_b30.mp4', 400, 300, '450', 'MP4 (h.264 baseline 3.0, aac-he)', 1, 1),
(48, 8, 'GB1101200428_448x336_600_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/gb1101/200428/GB1101200428_448x336_600_m30.mp4', 448, 336, '600', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(49, 8, 'GB1101200428_480x360_900_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/gb1101/200428/GB1101200428_480x360_900_m30.mp4', 480, 360, '900', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(50, 8, 'GB1101200428_576x432_1200_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/gb1101/200428/GB1101200428_576x432_1200_m30.mp4', 576, 432, '1200', 'MP4 (h.264 main 3.0, aac-he)', 1, 1),
(51, 8, 'GB1101200428_640x480_1600_m30.mp4', '/8619/_!/intlod/MTVInternational/sony_int/gb1101/200428/GB1101200428_640x480_1600_m30.mp4', 640, 480, '1600', 'MP4 (h.264 main 3.0, aac-he)', 1, 1);",
"INSERT INTO `thumbnail_tbl` (`thumbfile_id`, `video_id`, `thumb_local_location`, `thumb_dest_location`, `thumb_width`, `thumb_height`, `thumb_uploaded`) VALUES
(1, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_640x480_1.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_640x480_1.jpg', 640, 480, 1),
(2, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_640x480_2.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_640x480_2.jpg', 640, 480, 1),
(3, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_640x480_3.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_640x480_3.jpg', 640, 480, 1),
(4, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_400x300_1.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_400x300_1.jpg', 400, 300, 1),
(5, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_400x300_2.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_400x300_2.jpg', 400, 300, 1),
(6, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_400x300_3.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_400x300_3.jpg', 400, 300, 1),
(7, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_70x53_1.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_70x53_1.jpg', 70, 54, 1),
(8, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_70x53_2.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_70x53_2.jpg', 70, 54, 1),
(9, 3, '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115_70x53_3.jpg', '/8619/_!/intlod/MTVInternational/sony_int/usrzr1/232115/USRZR1232115_70x53_3.jpg', 70, 54, 1),
(10, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_640x480_1.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_640x480_1.jpg', 640, 480, 1),
(11, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_640x480_2.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_640x480_2.jpg', 640, 480, 1),
(12, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_640x480_3.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_640x480_3.jpg', 640, 480, 1),
(13, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_400x300_1.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_400x300_1.jpg', 400, 300, 1),
(14, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_400x300_2.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_400x300_2.jpg', 400, 300, 1),
(15, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_400x300_3.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_400x300_3.jpg', 400, 300, 1),
(16, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_70x53_1.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_70x53_1.jpg', 70, 54, 1),
(17, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_70x53_2.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_70x53_2.jpg', 70, 54, 1),
(18, 4, '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278_70x53_3.jpg', '/8619/_!/intlod/MTVInternational/sony_int/dec691/200278/DEC691200278_70x53_3.jpg', 70, 54, 1),
(19, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_640x480_1.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_640x480_1.jpg', 640, 480, 1),
(20, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_640x480_2.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_640x480_2.jpg', 640, 480, 1),
(21, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_640x480_3.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_640x480_3.jpg', 640, 480, 1),
(22, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_400x300_1.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_400x300_1.jpg', 400, 300, 1),
(23, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_400x300_2.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_400x300_2.jpg', 400, 300, 1),
(24, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_400x300_3.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_400x300_3.jpg', 400, 300, 1),
(25, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_70x53_1.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_70x53_1.jpg', 70, 54, 1),
(26, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_70x53_2.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_70x53_2.jpg', 70, 54, 1),
(27, 5, '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181_70x53_3.jpg', '/8619/_!/intlod/MTVInternational/umg_int/pla281/200181/PLA281200181_70x53_3.jpg', 70, 54, 1),
(28, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_640x480_1.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_640x480_1.jpg', 640, 480, 1),
(29, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_640x480_2.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_640x480_2.jpg', 640, 480, 1),
(30, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_640x480_3.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_640x480_3.jpg', 640, 480, 1),
(31, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_400x300_1.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_400x300_1.jpg', 400, 300, 1),
(32, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_400x300_2.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_400x300_2.jpg', 400, 300, 1),
(33, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_400x300_3.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_400x300_3.jpg', 400, 300, 1),
(34, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_70x53_1.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_70x53_1.jpg', 70, 54, 1),
(35, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_70x53_2.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_70x53_2.jpg', 70, 54, 1),
(36, 6, '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053_70x53_3.jpg', '/8619/_!/intlod/MTVInternational/umg_int/uscmv1/200053/USCMV1200053_70x53_3.jpg', 70, 54, 1),
(37, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_640x480_1.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_640x480_1.jpg', 640, 480, 1),
(38, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_640x480_2.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_640x480_2.jpg', 640, 480, 1),
(39, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_640x480_3.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_640x480_3.jpg', 640, 480, 1),
(40, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_400x300_1.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_400x300_1.jpg', 400, 300, 1),
(41, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_400x300_2.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_400x300_2.jpg', 400, 300, 1),
(42, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_400x300_3.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_400x300_3.jpg', 400, 300, 1),
(43, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_70x53_1.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_70x53_1.jpg', 70, 54, 1),
(44, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_70x53_2.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_70x53_2.jpg', 70, 54, 1),
(45, 7, '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003_70x53_3.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it8ad1/100003/IT8AD1100003_70x53_3.jpg', 70, 54, 1),
(46, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_640x480_1.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_640x480_1.jpg', 640, 480, 1),
(47, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_640x480_2.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_640x480_2.jpg', 640, 480, 1),
(48, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_640x480_3.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_640x480_3.jpg', 640, 480, 1),
(49, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_400x300_1.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_400x300_1.jpg', 400, 300, 1),
(50, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_400x300_2.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_400x300_2.jpg', 400, 300, 1),
(51, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_400x300_3.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_400x300_3.jpg', 400, 300, 1),
(52, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_70x53_1.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_70x53_1.jpg', 70, 54, 1),
(53, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_70x53_2.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_70x53_2.jpg', 70, 54, 1),
(54, 8, '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008_70x53_3.jpg', '/8619/_!/intlod/MTVInternational/wmg_int/it5591/200008/IT5591200008_70x53_3.jpg', 70, 54, 1);",
"INSERT INTO `videofile_tbl` (`videofile_id`, `video_id`, `video_orig_name`, `video_dest_name`, `duration_seconds`, `video_width`, `video_height`, `bitrate`, `hd`, `widescreen`, `downloaded`, `to_encode`, `sent_to_encoder`, `status`) VALUES
(1, 1, '5099970534351_01_001_110001.mpg', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 'Unprocessed'),
(2, 2, '5099970536058_01_001_110001.mpg', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 'Unprocessed'),
(3, 3, '00000000000026018148-mpg_type1007_a384_v15000_2c_cbr.mpg', '/var/www/Pepsid/packages_to_process/sony/USRZR1232115/USRZR1232115.mpg', 153, '640', 360, '170', 0, 0, 1, 1, 0, 'Package complete. UMA XML Uploaded'),
(4, 4, '00000000000026020519-mpg_type1007_a384_v15000_2c_cbr.mpg', '/var/www/Pepsid/packages_to_process/sony/DEC691200278/DEC691200278.mpg', 197, '640', 360, '170', 0, 0, 1, 1, 0, 'Package complete. UMA XML Uploaded'),
(5, 5, '00602537077069_PLA281200181.mpg', '/var/www/Pepsid/packages_to_process/umg/PLA281200181/PLA281200181.mpg', 210, '720', 576, '150', 0, 1, 1, 1, 0, 'Package complete. UMA XML Uploaded'),
(6, 6, '00602537070862_USCMV1200053.mpg', '/var/www/Pepsid/packages_to_process/umg/USCMV1200053/USCMV1200053.mpg', 285, '720', 480, '150', 0, 1, 1, 1, 0, 'Package complete. UMA XML Uploaded'),
(7, 7, 'IT8AD1100003_HDM.mp4', '/var/www/Pepsid/packages_to_process/wmg/IT8AD1100003/IT8AD1100003.mpg', 229, '1280', 564, '150', 1, 1, 1, 1, 0, 'Package complete. UMA XML Uploaded'),
(8, 8, 'IT5591200008_15320.mp4', '/var/www/Pepsid/packages_to_process/wmg/IT5591200008/IT5591200008.mpg', 260, '640', 288, '150', 0, 1, 1, 1, 0, 'Package complete. UMA XML Uploaded');",
"INSERT INTO `video_tbl` (`video_id`, `artist`, `track_name`, `date_encoded`, `label`, `umaid`, `isrc`, `upc`, `label_id`, `territories`, `date_ingested`, `source_location`, `updated_at`) VALUES
(1, 'Isaac Simpson Divine Providence', 'The Process (Official Music Video)', NULL, 'emi', NULL, 'QMY9J1200003', '5099970534351', '5099970534351', 'GB,AD,AE,AL,AM,AO,AQ,AS,AT,AZ,BA,BE,BF,BG,BH,BI,BJ,BV,BW,BY,CD,CF,CG,CH,CI,CK,CM,CS,CV,CY,CZ,DE,DJ,DK,DZ,EE,EG,EH,ER,ES,ET,FI,FO,FR,GA,GB,GH,GI,GM,GN,GQ,GR,GW,HR,HU,IE,IL,IO,IQ,IR,IS,IT,JM,JO,KE,KH,KM,KW,KZ,LB,LI,LR,LS,LT,LU,LV,LY,MA,MC,MD,MG,ML,MN,MR,MT,MU,MW,MZ,NA,NE,NG,NL,NO,OM,PF,PL,PT,QA,RO,RU,RW,SA,SC,SD,SE,SH,SI,SJ,SK,SL,SM,SN,SO,ST,SY,SZ,TD,TF,TG,TM,TN,TR,UA,UG,UZ,YE,YT,ZA,ZM,ZW,CA,PM,BD,BN,BT,CC,CN,CX,FM,GE,GU,HK,HM,ID,IN,KP,KR,LA,LK,MH,MO,MV,MY,NP,NR,PG,PH,PK,PN,PW,RE,SB,SG,TH,TJ,TK,TL', '2012-05-21 21:00:31', '/Deliveries/Video//mtveur_Video_20120519000000_NRO/5099970534351', NULL),
(2, 'White Rabbits', 'Temporary', NULL, 'emi', NULL, 'GBTBD1200015', '5099970536058', '5099970536058', 'GB,AE,AL,AM,AZ,BA,BG,BH,BY,CY,CZ,GB,HR,HU,IE,IL,IQ,IR,JO,KW,LB,MD,MT,OM,PL,QA,RO,RU,SA,SI,SK,SY,TR,UA,YE,GE,IN,', '2012-05-21 21:00:31', '/Deliveries/Video//mtveur_Video_20120519000000_NRO/5099970536058', NULL),
(3, 'For Today', 'Fearless: Behind the Scenes', NULL, 'sony', NULL, 'USRZR1232115', '793018150330', '00000000000026018148', 'US,', '2012-05-18 21:08:51', '/home/ftp/sonybmg/sonybmg//2556209/000/000/000/000/260/181/48/', NULL),
(4, 'Stefan Dettl', 'Summer Of Love', NULL, 'sony', NULL, 'DEC691200278', '886443482852', '00000000000026020519', 'AR,AT,AU,BE,BO,BR,CA,CH,CL,CO,CR,DE,EC,ES,GT,HN,IE,KZ,LU,MX,NI,NL,NO,NZ,PA,PE,PY,RU,SV,TR,UY,VE,', '2012-05-18 21:08:51', '/home/ftp/sonybmg/sonybmg//2556118/000/000/000/000/260/205/19/', NULL),
(5, 'Marcin Kindla', 'Jeszcze Si Spotkamy', NULL, 'umg', NULL, 'PLA281200181', '00602537077069', '00602537077069_PLA281200181_/12_05_18', 'Territories Unavailable.', '2012-05-19 09:01:31', '/12_05_18', NULL),
(6, 'Nicki Minaj', 'Right By My Side', NULL, 'umg', NULL, 'USCMV1200053', '00602537070862', '00602537070862_USCMV1200053_/12_05_18', 'Territories Unavailable.', '2012-05-19 09:01:31', '/12_05_18', NULL),
(7, 'Ligabue', 'Sotto bombardamento (videoclip)', NULL, 'wmg', NULL, 'IT8AD1100003', 'A10302B0001616748G', '20120605_0521_13', 'IT,', '2012-05-21 21:10:07', '/home/ftp/wmg/wmg/new_release/Assets_Only//20120605_0521_13/A10302B0001616748G', NULL),
(8, 'Arisa', 'Lamore  unaltra cosa videoclip)', NULL, 'wmg', NULL, 'IT5591200008', 'A10302B0001628765G', '20120605_0521_13', 'IT,', '2012-05-21 21:10:07', '/home/ftp/wmg/wmg/new_release/Assets_Only//20120605_0521_13/A10302B0001628765G', NULL);"
);

$xml = '<?xml version="1.0"?>'."\n";
$xml .= '<!DOCTYPE inserts SYSTEM "inserts.dtd">'."\n\n";
$xml .= '<inserts>'."\n";
foreach($sqlInserts as $insert){
	$insertArray = explode('VALUES', str_replace(array("\t", "\n"), '', $insert));
	$structureArray = explode('(', $insertArray[0]);
	$table = str_replace(array('INSERT INTO `', '` ', ' '), '', $structureArray[0]);
	$fields = explode(',', str_replace(array('(', ')', '`', ' '), '', $structureArray[1]));
	$entries = explode('),', str_replace(array(');'), '', $insertArray[1]));
	$xml .= "\t".'<entries table="'.$table.'">'."\n";
	foreach($entries as $entry){
		$xml .= "\t\t".'<entry>'."\n";
		$values = parseEntry($entry);
		$i = 0;
		foreach($values as $val){
			$xml .= "\t\t\t".'<field name="'.$fields[$i].'">'.$val.'</field>'."\n";
			++$i;
		}
		$xml .= "\t\t".'</entry>'."\n";
	}
	$xml .= "\t".'</entries>'."\n";
}
$xml .= '</inserts>';
echo $xml;
die();

function parseEntry($entry){
	$entry = str_replace(array('(', ' (', '  ('), '', $entry);
	$values = array();
	for($i = 0; $i < strlen($entry); $i++){
		if($entry{$i} != ' ' && $entry{$i} != ',' && ord($entry{$i}) != 10 && ord($entry{$i}) != 13){
			if (ord($entry{$i}) < 58 && ord($entry{$i}) > 47) {
				$currentValue = '';
				while($i < strlen($entry) && ord($entry{$i}) < 58 && ord($entry{$i}) > 47){
					$currentValue .= $entry{$i};
					++$i;
				}
				$values[] = $currentValue;
			} elseif ($entry{$i} == '\'') {
				$currentValue = '\'';
				++$i;
				while($entry{$i} != '\''){
					if(ord($entry{$i}) != 10 && ord($entry{$i}) != 13){
						$currentValue .= $entry{$i};
					}
					++$i;
				}
				$currentValue .= '\'';
				$values[] = $currentValue;
			} elseif (($entry{$i} == 'N' || $entry{$i} == 'n') && ($entry{$i+3} == 'L' || $entry{$i+3} == 'l')) {
				$values[] = 'NULL';
				$i += 3;
			} else {
				echo '<hr /><hr /><hr /><hr />';var_dump($values);echo '<hr />';
				echo $entry ."<br />";
				die('Error, non expected secuence of chars at posicion '.$i.' ASCII char '.ord($entry{$i}));
			}
		}
	}
	return $values;
}