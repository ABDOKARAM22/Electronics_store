<?php include "include/config.php";
	   $titel="Contact us";
      include "$head";
      include "$nav";
  ?>

<Section class="contact">
  <div class="container">
    <br><br><br>
    <br><br><br>
    <br><br><br>
    <h2><center>Contact Us</center></h2>
    <hr>
          <div class="row">
                  <div class="col-6 m-auto">
                    <form>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="validationCustom01">First Name</label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="First Name">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="validationCustom02">Last Name</label>
                            <input type="text" class="form-control" id="inputPassword4" placeholder="Last Name">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail4">Email</label>
                          <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                        <div class="form-group">
                          <label for="inputAddress2">Message</label>
                          <input type="text" class="form-control" id="inputAddress2" placeholder="Comment ...">
                        </div>
                        
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                      </form>

                    </div>
                  </div>
                </div>
              </Section>
              <br><br><br><br><br>
              <br><br><br><br>
    <?php include "$footer" ?>
