<!-- contact.php - Trang liên hệ -->
<main>
    <!-- Banner Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h1 class="display-5 fw-bold mb-4">Liên hệ với chúng tôi</h1>
                    <p class="lead">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy liên hệ với CameraVN qua các phương thức bên dưới.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up">
                    <div class="contact-info-card h-100">
                        <div class="contact-info-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h3>Địa chỉ</h3>
                        <p>Đại học Tôn Đức Thắng<br>19 Nguyễn Hữu Thọ, Quận 7<br>TP. Hồ Chí Minh</p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-info-card h-100">
                        <div class="contact-info-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <h3>Điện thoại</h3>
                        <p>
                            <a href="tel:0708624193">0708624193</a><br>
                            <a href="tel:0868212407">0868212407</a><br>
                            <a href="tel:0945727010">0945727010</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-info-card h-100">
                        <div class="contact-info-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <h3>Email</h3>
                        <p>
                            <a href="mailto:52300262@student.tdtu.edu.vn">52300262@student.tdtu.edu.vn</a><br>
                            <a href="mailto:52300154@student.tdtu.edu.vn">52300154@student.tdtu.edu.vn</a><br>
                            <a href="mailto:52300274@student.tdtu.edu.vn">52300274@student.tdtu.edu.vn</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center" data-aos="fade-up">
                    <h2 class="section-title">Gửi thông tin liên hệ</h2>
                    <p class="text-muted mb-5">Hãy điền thông tin bên dưới và chúng tôi sẽ phản hồi trong thời gian sớm nhất</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="card border-0 shadow">
                        <div class="card-body p-5">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Họ và tên *</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Địa chỉ email *</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Chủ đề *</label>
                                        <select class="form-select" id="subject" required>
                                            <option value="" selected disabled>Chọn chủ đề</option>
                                            <option value="Tư vấn sản phẩm">Tư vấn sản phẩm</option>
                                            <option value="Bảo hành/Sửa chữa">Bảo hành/Sửa chữa</option>
                                            <option value="Đơn hàng/Vận chuyển">Đơn hàng/Vận chuyển</option>
                                            <option value="Góp ý/Khiếu nại">Góp ý/Khiếu nại</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Nội dung liên hệ *</label>
                                        <textarea class="form-control" id="message" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h2 class="text-center section-title mb-5">Bản đồ cửa hàng</h2>
                    <div class="map-container shadow">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3920.111649605087!2d106.70966871010545!3d10.732624559766575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f9023a3a85d%3A0x26b6a9b2a7f9141f!2sTon%20Duc%20Thang%20University!5e0!3m2!1sen!2s!4v1652841668711!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stores Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center" data-aos="fade-up">
                    <h2 class="section-title">Hệ thống cửa hàng</h2>
                    <p class="text-muted mb-5">Ghé thăm các cửa hàng của CameraVN trên toàn quốc</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up">
                    <div class="store-card h-100">
                        <div class="store-image" style="background-image: url('View/assets/images/stores/store1.jpg');"></div>
                        <div class="store-details">
                            <h4>CameraVN - TP. Hồ Chí Minh</h4>
                            <ul class="store-info-list">
                                <li><i class="bi bi-geo-alt"></i> 19 Nguyễn Hữu Thọ, Quận 7, TP. Hồ Chí Minh</li>
                                <li><i class="bi bi-telephone"></i> 028 3775 5678</li>
                                <li><i class="bi bi-envelope"></i> hcm@cameravn.com</li>
                                <li><i class="bi bi-clock"></i> 8:00 - 20:00 (Thứ 2 - Chủ Nhật)</li>
                            </ul>
                            <a href="https://goo.gl/maps/1B6JqDfZA6ZSGJE97" class="btn btn-outline-primary" target="_blank">Xem bản đồ</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="store-card h-100">
                        <div class="store-image" style="background-image: url('View/assets/images/stores/store2.jpg');"></div>
                        <div class="store-details">
                            <h4>CameraVN - Hà Nội</h4>
                            <ul class="store-info-list">
                                <li><i class="bi bi-geo-alt"></i> 54 Lê Thanh Nghị, Hai Bà Trưng, Hà Nội</li>
                                <li><i class="bi bi-telephone"></i> 024 3869 4321</li>
                                <li><i class="bi bi-envelope"></i> hanoi@cameravn.com</li>
                                <li><i class="bi bi-clock"></i> 8:00 - 20:00 (Thứ 2 - Chủ Nhật)</li>
                            </ul>
                            <a href="https://goo.gl/maps/1B6JqDfZA6ZSGJE97" class="btn btn-outline-primary" target="_blank">Xem bản đồ</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="store-card h-100">
                        <div class="store-image" style="background-image: url('View/assets/images/stores/store3.jpg');"></div>
                        <div class="store-details">
                            <h4>CameraVN - Đà Nẵng</h4>
                            <ul class="store-info-list">
                                <li><i class="bi bi-geo-alt"></i> 123 Nguyễn Văn Linh, Hải Châu, Đà Nẵng</li>
                                <li><i class="bi bi-telephone"></i> 0236 3759 987</li>
                                <li><i class="bi bi-envelope"></i> danang@cameravn.com</li>
                                <li><i class="bi bi-clock"></i> 8:00 - 20:00 (Thứ 2 - Chủ Nhật)</li>
                            </ul>
                            <a href="https://goo.gl/maps/1B6JqDfZA6ZSGJE97" class="btn btn-outline-primary" target="_blank">Xem bản đồ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center" data-aos="fade-up">
                    <h2 class="section-title">Kết nối với chúng tôi</h2>
                    <p class="text-muted mb-5">Theo dõi CameraVN trên các nền tảng mạng xã hội</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up">
                    <div class="social-card facebook">
                        <div class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </div>
                        <h4 class="mb-3">Facebook</h4>
                        <p>Cập nhật tin tức và khuyến mãi mới nhất</p>
                        <a href="https://facebook.com" class="btn btn-light mt-3" target="_blank">Theo dõi</a>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up">
                    <div class="social-card facebook">
                        <div class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </div>
                        <h4 class="mb-3">Facebook</h4>
                        <p>Cập nhật tin tức và khuyến mãi mới nhất</p>
                        <a href="https://facebook.com" class="btn btn-light mt-3" target="_blank">Theo dõi</a>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up">
                    <div class="social-card facebook">
                        <div class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </div>
                        <h4 class="mb-3">Facebook</h4>
                        <p>Cập nhật tin tức và khuyến mãi mới nhất</p>
                        <a href="https://facebook.com" class="btn btn-light mt-3" target="_blank">Theo dõi</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq-section" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center" data-aos="fade-up">
                    <h2 class="section-title">Câu hỏi thường gặp</h2>
                    <p class="text-muted mb-5">Một số câu hỏi thường gặp về dịch vụ của CameraVN</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Thời gian giao hàng là bao lâu?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Thời gian giao hàng tùy thuộc vào khu vực. Đối với nội thành TP.HCM và Hà Nội, thời gian giao hàng từ 1-2 ngày làm việc. Đối với các tỉnh thành khác, thời gian giao hàng từ 2-5 ngày làm việc.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Chính sách bảo hành như thế nào?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Tất cả sản phẩm tại CameraVN đều được bảo hành chính hãng từ 12-24 tháng tùy theo từng sản phẩm. Khách hàng có thể mang sản phẩm đến trực tiếp các cửa hàng của CameraVN hoặc các trung tâm bảo hành chính hãng trên toàn quốc.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    CameraVN có chính sách đổi trả không?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    CameraVN có chính sách đổi trả trong vòng 7 ngày đối với sản phẩm lỗi do nhà sản xuất. Sản phẩm đổi trả phải còn nguyên hộp, đầy đủ phụ kiện và không có dấu hiệu va đập, trầy xước do người sử dụng.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Làm thế nào để mua hàng tại CameraVN?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bạn có thể mua hàng trực tiếp tại các cửa hàng của CameraVN hoặc đặt hàng online thông qua website cameravn.com. Sau khi đặt hàng online, nhân viên của chúng tôi sẽ liên hệ xác nhận và tiến hành giao hàng cho bạn.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    CameraVN có dịch vụ cho thuê thiết bị không?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có, CameraVN có dịch vụ cho thuê các thiết bị nhiếp ảnh và quay phim chuyên nghiệp. Vui lòng liên hệ trực tiếp với cửa hàng gần nhất hoặc gọi đến hotline để biết thêm chi tiết về dịch vụ này.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <p class="mb-3">Không tìm thấy câu trả lời bạn cần?</p>
                        <a href="#contact-form" class="btn btn-primary">Liên hệ với chúng tôi</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>