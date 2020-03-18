DROP TABLE IF EXISTS `#__encrypt_keys`;
DROP TABLE IF EXISTS `#__encrypt_gendata`;

CREATE TABLE `#__encrypt_keys` (
		  `keys_id` int(11) NOT NULL auto_increment,
		  `algorithm` tinyint(3) NOT NULL default '1',
		  `private_key` text NOT NULL,
		  `e` text NOT NULL,
		  `n` text NOT NULL,
		  `random_des` tinyint(3) NOT NULL default '1',
		  `des_key` varchar(255) NOT NULL,
		  `encrypted_key` tinyint(3) NOT NULL default '0',
		  `gen_time` datetime NULL,
		  PRIMARY KEY  (`keys_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		
CREATE TABLE `#__encrypt_gendata` (
		  gen_key int(11) NOT NULL auto_increment,
		  gen_data text NULL,
		  PRIMARY KEY  (`gen_key`)
		) ENGINE=MyISAM;


INSERT INTO #__encrypt_keys(algorithm, private_key, e, n, des_key, gen_time)
		VALUES(2, 
			'-----BEGIN RSA PRIVATE KEY-----\r\nMIICXAIBAAKBgQCreTknt5KE5RKJJMKYcO8bxm9KRsuNGhbMpsFQU7r//7XxO9Z5TsOJWK4BZtGl\r\nQUWR+uqAYnxDgs/BMwPIkTXw4sxn8BZ+5JepLXSa0iDxHDVAfKZgYZeTU7U0wqRYKSa0f2y6gRYE\r\nzUXQzwC30XSnLLTO7UzcDslnljENmXyCowIDAQABAoGAA719qymcZwyuFlK4ceXIuWTfKZIYv4ep\r\npqYegleJNStJNy1UdMnshvLpvLsW6JFfaJs+ATXkuv4/9NldhELyl7jTRcZbg/Ee7mYIebt1BjLe\r\ngqkVQxBx2MX2O5nn/0BmBxBP+pdOhS0BA1R9Uo05vhF1R+vDDXBr35FvxJpdfNECQQDnacEamxI8\r\n40zryHmRo8kwDnsD2cXdDJ9mBtxg1qPsYEbuT4MBGYXYfJFT+IgXJZuesvCO9SbkWuMW/E8A65jT\r\nAkEAvbEpc71z4jKzTCvbx4/AsypZBSAHuML3i1zwwd1BjZTUHvDSRD30QGpGGzHn0S3FxAcsWgyi\r\nuY2XJ9e0GIFM8QJASDaNJuNLPqrjnxRRM2x75L4wDxSPFRrSRwFPFf0E7Edi+wze4aH4TYUZyK1e\r\nsnJu7IgEX2gK+emOweZ8NNpQNwJAIbYddstBj/6QrMXSnkmm5nBtN6L0nFpR4fuXceyfXMkJVaJY\r\ny/XytYvtf6HD4AHxdqALuskqFi3aoiMMh5pbEQJBAIu4dl1IcAweENEoIdaJvG/RshMNoGI7kDUy\r\ngiijOCCt6xjBUucVFVftbBrDQYzvX+/ZCxUSlQX7BHR5hKu8/4Q=\r\n-----END RSA PRIVATE KEY-----', 
			'10001', 
			'ab793927b79284e5128924c29870ef1bc66f4a46cb8d1a16cca6c15053baffffb5f13bd6794ec38958ae0166d1a5414591faea80627c4382cfc13303c89135f0e2cc67f0167ee497a92d749ad220f11c35407ca66061979353b534c2a4582926b47f6cba811604cd45d0cf00b7d174a72cb4ceed4cdc0ec96796310d997c82a3', 
			'534656jdsf787GERT453', '2000-05-22 09:19:35');
			