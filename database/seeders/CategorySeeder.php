<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'tội phạm',
                'detail' => 'Bối cảnh phim là các hoạt động tội ác, thường có sự đối đầu giữa cảnh sát và tội phạm. 
                            Một phim được xếp vào thể loại hình sự thường sẽ có thêm thể loại phụ là hành động vì kịch bản phim rất hay 
                            có cảnh truy đuổi và đối đầu giữa cảnh sát và tội phạm'
            ],
            [
                'name' => 'lịch sử',
                'detail' => 'Bối cảnh phim là các thời điểm trong quá khứ, thường gắn với các sự kiện lịch sử quan trọng'
            ],
            [
                'name' => 'chiến tranh',
                'detail' => ' Bối cảnh là các trận chiến và thời gian chiến tranh, đây cũng có thể coi là tiểu thể loại của phim lịch sử 
                            nếu các sự kiện chiến tranh là có thật trong quá khứ'
            ],
            [
                'name' => 'khoa học viễn tưởng',
                'detail' => 'Bối cảnh phim có xuất hiện những công nghệ, kỹ thuật hiện đại chưa hoặc không có thật trong thực tế (như du hành thời gian,...), 
                            thời gian của phim thường được đặt ở tương lai'
            ],
            [
                'name' => 'viễn Tây ',
                'detail' => 'Bối cảnh thường là cuộc sống và thiên nhiên ở miền Tây Hoa Kỳ. Các phim miền Tây thường là phim hành động'
            ],
            [
                'name' => 'kiếm hiệp ',
                'detail' => 'Phim đặc trưng của châu Á, thường có bối cảnh là thời phong kiến và có rất nhiều cuộc giao tranh bằng vũ khí lạnh (kiếm, đao,...). 
                            Nếu có các yếu tố phi thực tế, phim kiếm hiệp còn có thể xếp vào loại phim giả tưởng hoặc phim thần bí.'
            ],
            [
                'name' => 'cổ trang',
                'detail' => 'phản ánh lịch sử, phản ảnh sự thật, nhân vật lịch sử, sự kiện lịch sử như thế nào thì phản ánh như thế, không được bịa ra. 
                            Loại thứ hai là nửa thật nửa giả: Có nhân vật lịch sử thật nhưng sự kiện, sự việc có thể hư cấu hoặc sự kiện có thật nhưng nhân vật hư cấu'
            ],
            [
                'name' => 'hành động',
                'detail' => 'Thường bao gồm sự đối đầu giữa "cái thiện" và "cái ác" với nhiều cuộc chiến ác liệt bằng tay không hoặc vũ khí, 
                            tiết tấu nhanh và kĩ xảo điện ảnh cao.'
            ],
            [
                'name' => 'phiêu lưu',
                'detail' => 'Bao gồm các chuyến du hành mạo hiểm chứa đựng nhiều hiểm nguy hoặc may mắn, đôi khi có yếu tố thần thoại.
                            Phim bí ẩn (Mystery film): Thường là quá trình điều tra về một bí ẩn chưa được khám phá.'
            ],
            [
                'name' => 'hài kịch',
                'detail' => 'Chứa đựng nhiều chi tiết hài hước để gây cười cho người xem'
            ],
            [
                'name' => 'kinh dị',
                'detail' => 'Là một thể loại phim với nội dung chính đưa đến cho khán giả những cảm xúc tiêu cực, 
                            gợi cho người xem nỗi sợ hãi nguyên thủy nhất thông qua cốt truyện, nội dung phim, những hình ảnh rùng rợn, bí hiểm, 
                            ánh sáng mờ ảo, những âm thanh rùng rợn, nhiều cảnh máu me, chết chóc... hay có những cảnh giật mình thông qua các sự kiện 
                            hoặc nhân vật có nguồn gốc siêu nhiên (như ma quỷ, người ngoài hành tinh, thế lực huyền bí...), 
                            do đó thể loại phim này đôi khi có chồng lấn với các thể loại phim giả tưởng, viễn tưởng.'
            ],
            [
                'name' => 'giật gân',
                'detail' => ' Là một thể loại rộng lớn của văn chương, phim ảnh, truyền hình có sử dụng yếu tố hồi hộp, 
                            căng thẳng như là yếu tố chính của phim. Phim giật gân rất kích thích tâm trạng của người xem, 
                            đem lại cho họ một mức độ cao của sự mong đợi, kỳ vọng cực cao, không chắc chắn, bất ngờ, lo lắng... 
                            Phim thể loại này thường có xu hướng gay cấn gấp rút, gai góc và nhịp độ nhanh. 
                            Thể loại phim giật gân phổ biến nhất là: phim giật gân tâm lý, phim giật gân tội phạm, phim giật gân khiêu dâm và phim giật gân bí ẩn.'
            ],
            [
                'name' => 'kỳ ảo',
                'detail' => 'bối cảnh không có thực, thường liên quan tới hiện tượng siêu nhiên, magic.Phim tưởng tượng được đánh giá là 
                            khác xa với thể loại phim Kinh dị hoặc Phim Khoa học Viễn tưởng.'
            ],
            [
                'name' => 'chính kịch',
                'detail' => 'Thường tập trung nói về cuộc đời hoặc một giai đoạn trong cuộc đời của nhân vật chính'
            ],
            [
                'name' => 'lãng mạn',
                'detail' => 'Tập trung khai thác tình yêu lãng mạn giữa các nhân vật chính'
            ],
            [
                'name' => 'hoạt hình',
                'detail' => 'Thay vì quay các hình ảnh có sẵn, các cảnh trong phim hoạt hình được thực hiện bằng hình vẽ, 
                            trước đây là do họa sĩ vẽ tay còn hiện nay trong nhiều phim công đoạn này được vẽ bằng máy vi tính'
            ],
            [
                'name' => 'tài liệu',
                'detail' => 'Phim được quay trực tiếp dựa vào các hình ảnh ngoài thực tế, không có hoặc rất ít các chỉ đạo diễn xuất của đạo diễn. 
                            Nếu các sự kiện được mô tả trong phim mới xảy ra có tính chất thời sự cao thì phim sẽ được xếp vào thể loại phim thời sự'
            ],
            [
                'name' => 'khoa học',
                'detail' => 'Là một dạng phim tài liệu tập trung vào các hiện tượng, công trình mang tính khoa học'
            ],
            [
                'name' => 'ca nhạc',
                'detail' => 'Các nhân vật ít thoại hơn bình thường, thay vào đó là nhiều bài hát do chính các diễn viên thể hiện'
            ],
            [
                'name' => 'trẻ em',
                'detail' => 'Là các phim có nội dung dành cho trẻ em, phim thường có nội dung đơn giản, dễ hiểu, nhiều màu sắc và thường là phim hài'
            ],
            [
                'name' => 'gia đình',
                'detail' => 'Hướng tới đối tượng là mọi lứa tuổi thường có trong một gia đình, phim thích hợp để xem tập thể, 
                            thường có kết cục có hậu (happy ending) và hay được phát hành vào các dịp nghỉ như Giáng sinh.'
            ],
            [
                'name' => 'người lớn',
                'detail' => 'Hướng đối tượng cho những người trưởng thành, thường có nội dung phức tạp hơn và bao gồm những cảnh tình dục, bạo lực.'
            ]
        ]);
    }
}
