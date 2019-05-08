<style>
.auth {
  position: fixed;
  z-index: 2000;
  width: 100%;
  height: 100%;
  top: 0px;
  background: #fff;
  font-weight: bold !important;
}

.auth > .left, .auth > .right {
  position: absolute;
  display: inline-block;
  width: 50%;
  height: 100%;
  overflow: hidden;
}

.auth > .right {
  left: 50%;
}

.auth > .left {
  background: #1da1f2;
  left: 0px;
}

.auth > .right {
  background: #fff;
}

.auth .left .bg {
  position: relative;
  top: -25%;
  left: 65%;
  transform: translateX(-50%);

}

.auth .left .bg i {
  font-size: 1200px;
  color: rgb(14, 146, 227);
}

.auth .left ul {
  position: absolute;
  left: 50%;
  top: 35%;
  transform: translate(-50%);
  color: #fff;
  z-index: 2001;
}

.auth .left ul li {
  white-space: nowrap;
}

.auth .left ul li i {
  font-size: 28px;
  margin: 20px 0;
  margin-right: 15px;
}

.auth .left ul li span {
  font-size: 18px;
  font-weight: bold;
}

/* right */
.auth .right {
  border: 0px solid;
}

.auth .right > .wrapper {
  position: absolute;
  display: inline-block;
  left: 25%;
  top: 50%;
  transform: translateX(-50%);
  transform: translateY(-50%);
}

.auth .right > .wrapper > * {
  display: block;
}

.auth .right .wrapper i.fa-twitter {
  font-size: 46px;
  color: #09e;
  margin-bottom: 7px;
}

.auth .right .wrapper p {
  font-size: 26px;
  line-height: 32px;
  margin-bottom: 45px;
}

.auth .right .wrapper h1 {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 16px;
}

.auth .right .wrapper button {
  border-radius: 30px !important;
  width: 350px;
  height: 32px;
  line-height: 0;
  font-weight: bold;
}

.auth .right .wrapper button.toSignUp {
  display: inline-block;
  margin-bottom: 16px !important;
  border: 0px solid;
  background: #0ae;
}

.auth .right .wrapper button.toLogIn {
  color: #0ae;
  background: #fff;
}
</style>
