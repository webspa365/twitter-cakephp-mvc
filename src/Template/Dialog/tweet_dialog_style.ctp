<style>
.tweetDialog {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0px;
  z-index: 300;
  background: rgba(0, 0, 0, 0.5);
}

.tweetDialog .wrapper {
  position: relative;
  margin: 0 auto;
  top: 150px;
  width: 610px;
  background: #fff;
  border-radius: 7.5px;
}

.tweetDialog .modal-header {
  height: 50px;
  padding: 0px;
  border-bottom: 1px solid #eee;
}

.tweetDialog .modal-header > h3 {
  position: relative;
  text-align: center;
  width: 100%;
  top: 10px;
  font-size: 20px;
  font-weight: bold;
  border: 0px solid;
}

.tweetDialog .modal-header i {
  position: absolute;
  right: 0px;
  top: 0px;
  font-size: 18px;
  padding: 15px;
}

.tweetDialog .modal-body .avatar {
  position: absolute;
  left: 15px;
  top: 15px;
  width: 32px;
  height: 32px;
  border: 1px solid #ccc;
  border-radius: 100%;
  background: #eee;
  overflow: hidden;
  text-align: center;
  padding-top: 5px;
}

.tweetDialog .modal-body .avatar i {
  font-size: 32px;
  color: #888;
}

.tweetDialog .modal-body .avatar img {
  position: absolute;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
}

.tweetDialog .modal-body {
  position: relative;
}

.tweetDialog .modal-body .textarea {
  position: relative;
  display: inline-block;
  top: 0px;
  width: 100%;
  height: auto;
  padding-left: 44px;
}

.tweetDialog .modal-body .textarea textarea {
  height: 80px;
  resize: none;
  font-size: 14px;
  border-radius: 5px;
  border: 1px solid #ccc;
  left: 20%;
  width: 95%;
  margin-top: 15px;
  margin-left: 15px;
  margin-bottom: 0px;
}

.tweetDialog .modal-footer {
  position: relative;
  display: block;
  padding: 0px;
  border-top: 0px solid;
  margin-top: 15px;
}

.tweetDialog .modal-footer > div {
  position: relative;
  display: block;
  width: 100%;
  height: 44px;
  top: -15px;
}

.tweetDialog .modal-footer .icons {
  position: absolute;
  width: 100%;
  padding-left: 60px;
  margin-top: 7.5px;
}

.tweetDialog .modal-footer .icons li {
  display: inline-block;
  float: left;
  font-size: 21px;
  color: #888;
  padding-left: 15px;
  padding-right: 15px;
}

.tweetDialog .modal-footer .button {
  position: relative;
  float: right;
  border-radius: 30px;
  top: 15px;
  height: 34px;
  line-height: 17px;
  opacity: 0.5;
  margin-right: 15px;
  padding: 0px 15px;
}

.tweetDialog .modal-footer .addButton {
  background: #fff;
  color: #888;
  width: 34px;
  text-align: center;
  padding: 0px;
}

.tweetDialog .modal-footer .addButton i {
  position: relative;
  top: 1px;
  width: 32px;
}

.tweetDialog .modal-footer .tweetButton {
  font-weight: bold;
  background: #0ae !important;
  border-color: #0ae !important;
}

.tweetDialog .modal-footer .addButton.active,
.tweetDialog .modal-footer .tweetButton.active {
  opacity: 1;
}

.tweetDialog .modal-footer .message {
  white-space: nowrap;
  padding-right: 15px;
  height: auto !important;
  left: 0px;
  color: red;
  border: 0px solid;
  text-align: right;
}

</style>
