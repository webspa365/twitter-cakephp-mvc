<style>
.editProfile {
  position: relative;
}

.editProfile .container {
  width: 1190px;
  margin: 0 auto;
}

.editProfile .bg {
  position: relative;
  width: 100%;
  height: auto;
  background: #888;
  margin-top: 46px;
  padding-top: 25%;
  overflow: hidden;
}

.editProfile .bg img, .editProfile .bg input {
  position: absolute;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
}

.editProfile .bg img {
  height: auto;
  opacity: 0.5;
}

.editProfile .bg input {
  opacity: 0;
}

.editProfile .bg .message {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  display: inline-block;
  text-align: center;
  top: 200px;
  color: #fff;
}

.editProfile .bg .message i {
  font-size: 38px;
  margin-bottom: 7.5px;
}

.editProfile .bg .message span {
  font-size: 20px;
  font-weight: bold;
}

.editProfile .nav {
  position: relative;
  width: 100%;
  height: 60px;
  top: 0px;
  background: #fff;
  box-shadow: 1px 2px 1px #ddd;
  z-index: 100;
}

.editProfile .nav > div {
  position: relative;
}

.editProfile .nav .avatar {
  position: absolute;
  width: 210px;
  height: 210px;
  left: 0px;
  top: -105px;
  border: 5px solid #fff;
  border-radius: 100%;
  z-index: 101;
  background: #888;
  text-align: center;
  overflow: hidden;
}

.editProfile .nav .avatar img, .editProfile .nav .avatar input {
  position: absolute;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
}

.editProfile .nav .avatar img {
  width: auto;
  height: auto;
  max-width: auto !important;
  max-height: auto !important;
  opacity: 0.5;
}

.editProfile .nav .avatar input  {
  opacity: 0;
}

.editProfile .nav .avatar .message {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
  color: white;
}

.editProfile .nav .avatar .message i {
  font-size: 38px;
  margin-bottom: 5px;
}

.editProfile .nav .avatar .message span {
  font-size: 20px;
  font-weight: bold;
}

.editProfile .nav .button {
  float: right;
  min-width: 105px;
  height: 36px;
  border-radius: 100px;
  font-weight: bold;
  background: #fff;
  color: #0af;
  border: 1px solid #0af;
  margin-top: 12px;
  margin-left: 15px;
  font-size: 15px;
}

.editProfile .nav .button:first-child {
  color: #888;
}

.editProfile .main {
  position: relative;
  width: 100%;
  margin-top: 15px;
  border: 0px solid;
}

.editProfile .main > div {
  position: relative;
  display: block;
  margin: 0 auto;
}

.editProfile .main .left {
  height: auto;
  background: #fff;
  border: 1px solid #ccc;
  margin-top: 45px;
  margin-bottom: 30px;
  padding-top: 10px;
  padding-left: 15px;
  padding-right: 15px;
  width: 27%;
}

.editProfile .main .left .info label {
  margin: 0px;
  margin-top: 4px;
  margin-bottom: 4px;
  color: #888;
}

.editProfile .main .left .info input {
  width: 100%;
  height: 32px;
  border-radius: 15px;
}

.editProfile .main .left .info textarea {
  resize: none;
  height: 200px;
  margin-top: 3.5px;
  margin-bottom: 15px;
  font-size: 14px;
}
</style>
